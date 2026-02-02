<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('frontend.login')->with('error', 'Please login to proceed to checkout.');
        }

        // Migrate guest cart items to user
        Cart::where('session_id', session()->getId())
            ->whereNull('user_id')
            ->update(['user_id' => auth()->id(), 'session_id' => null]);

        $itemIds = $request->query('items') ? explode(',', $request->query('items')) : [];
        $cartItems = $this->getCartItems($itemIds);

        if ($cartItems->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Please select at least one item to checkout.');
        }

        $subtotal = $this->getCartTotal($itemIds);
        $shipping = 0; // Fixed zero shipping cost as specified
        $total = $subtotal + $shipping;

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'shipping', 'total', 'itemIds'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,stripe,jazzcash,easypaisa',
            'stripeToken' => 'required_if:payment_method,stripe',
            'payment_proof' => 'required_if:payment_method,jazzcash|required_if:payment_method,easypaisa|image|mimes:jpeg,png,jpg,webp|max:5120',
            'selected_items' => 'required|string', // IDs passed from hidden input
        ]);

        $itemIds = explode(',', $request->selected_items);
        $cartItems = $this->getCartItems($itemIds);

        if ($cartItems->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Your selection is no longer available.');
        }

        $subtotal = $this->getCartTotal($itemIds);
        $shipping = 0;
        $total = $subtotal + $shipping;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'order_notes' => $request->order_notes,
                'payment_proof' => $request->hasFile('payment_proof') ? $request->file('payment_proof')->store('payment_proofs', 'public') : null,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->discount_price ?? $item->product->price,
                    'purchase_price' => $item->product->purchase_price,
                    'size' => $item->size,
                    'color' => $item->color,
                ]);
            }

            // Handle Stripe Payment
            if ($request->payment_method === 'stripe') {
                $stripeSecret = config('services.stripe.secret');
                
                if ($total < 150) {
                     DB::rollBack();
                     return back()->with('error', 'The total amount must be at least PKR 150 to pay via Card. Current total: PKR ' . $total);
                }

                if ($stripeSecret === 'sk_test_your_secret_key' || empty($stripeSecret)) {
                    $order->update(['payment_status' => 'paid', 'order_notes' => ($order->order_notes ? $order->order_notes . "\n" : "") . "[TEST MODE] Mock Stripe payment successful."]);
                } else {
                    Stripe::setApiKey($stripeSecret);
                    
                    $charge = Charge::create([
                        'amount' => $total * 100, 
                        'currency' => 'pkr',
                        'description' => 'Payment for Order ' . $order->order_number,
                        'source' => $request->stripeToken,
                        'metadata' => ['order_id' => $order->id],
                    ]);

                    if ($charge->status === 'succeeded') {
                        $order->update(['payment_status' => 'paid']);
                    } else {
                        throw new \Exception('Payment failed. Please try again.');
                    }
                }
            }

            // Clear ONLY selected items from Cart
            Cart::where('user_id', auth()->id())
                ->whereIn('id', $itemIds)
                ->delete();

            DB::commit();

            return redirect()->route('frontend.order.success', $order->order_number)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function success($orderNumber)
    {
        $order = Order::with('items.product')->where('order_number', $orderNumber)->where('user_id', auth()->id())->firstOrFail();
        return view('frontend.order-success', compact('order'));
    }

    private function getCartItems($ids = [])
    {
        $query = Cart::with('product')->where('user_id', auth()->id());
        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }
        return $query->get();
    }

    private function getCartTotal($ids = [])
    {
        $items = $this->getCartItems($ids);
        $total = 0;
        foreach($items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $total += $price * $item->quantity;
        }
        return $total;
    }
}
