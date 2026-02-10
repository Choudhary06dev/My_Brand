<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use \App\Traits\LogsActivity;

    /**
     * Display a listing of the user's orders.
     */
    public function orders()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.profile.orders', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function orderDetail($order_number)
    {
        $order = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->where('order_number', $order_number)
            ->firstOrFail();

        return view('frontend.profile.order-detail', compact('order'));
    }

    public function cancelOrder($order_number)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('order_number', $order_number)
            ->firstOrFail();

        // Check if order is cancellable
        $cancellable_statuses = ['pending', 'confirmed', 'processing'];
        
        if (!in_array(strtolower($order->status), $cancellable_statuses)) {
            return back()->with('error', 'This order cannot be cancelled as it is already ' . str_replace('_', ' ', $order->status) . '.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        $this->logActivity('Cancel Order', "Customer cancelled order #{$order->order_number}");

        return back()->with('success', 'Your order has been cancelled successfully.');
    }
    public function reorder($order_number)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('order_number', $order_number)
            ->firstOrFail();

        $added_count = 0;
        foreach ($order->items as $item) {
            if ($item->product && $item->product->status == 1) {
                // Add to cart logic
                $cartItem = \App\Models\Cart::where('user_id', Auth::id())
                    ->where('product_id', $item->product_id)
                    ->where('size', $item->size)
                    ->where('color', $item->color)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $item->quantity;
                    $cartItem->save();
                } else {
                    \App\Models\Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'size' => $item->size,
                        'color' => $item->color,
                    ]);
                }
                $added_count++;
            }
        }

        if ($added_count > 0) {
            return redirect()->route('frontend.cart')->with('success', 'Items from your previous order have been added to your cart.');
        }

        return back()->with('error', 'Sorry, the products from this order are no longer available.');
    }

    public function wallet()
    {
        $transactions = Auth::user()->transactions()->latest()->paginate(10);
        return view('frontend.profile.wallet', compact('transactions'));
    }
}
