<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('frontend.login');
        }
        $cartItems = $this->getCartItems();
        return view('frontend.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Please login to add to cart', 'redirect' => route('frontend.login')], 401);
        }

        $sessionId = session()->getId();
        $userId = auth()->id();
        $quantity = $request->quantity ?? 1;
        $size = $request->size;
        $color = $request->color;

        // Simplified query construction
        $query = \App\Models\Cart::where('product_id', $request->product_id);
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        if ($size) {
            $query->where('size', $size);
        } else {
            $query->whereNull('size');
        }

        if ($color) {
            $query->where('color', $color);
        } else {
            $query->whereNull('color');
        }

        $cartItem = $query->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            \App\Models\Cart::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $request->product_id,
                'quantity' => $quantity,
                'size' => $size,
                'color' => $color,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully!',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = \App\Models\Cart::find($request->id);
        
        // Security check
        if ($cartItem->user_id && $cartItem->user_id != auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }
        if (!$cartItem->user_id && $cartItem->session_id != session()->getId()) {
             return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated successfully!',
            'subtotal' => $cartItem->product->price * $cartItem->quantity, // Assuming price exists
            'total' => $this->getCartTotal()
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
        ]);

        $cartItem = \App\Models\Cart::find($request->id);

        // Security check
        if ($cartItem->user_id && $cartItem->user_id != auth()->id()) {
             return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }
        if (!$cartItem->user_id && $cartItem->session_id != session()->getId()) {
             return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from cart!',
            'cart_count' => $this->getCartCount(),
            'total' => $this->getCartTotal()
        ]);
    }

    public function cartCount()
    {
        return response()->json(['count' => $this->getCartCount()]);
    }

    private function getCartItems()
    {
        if (auth()->check()) {
            return \App\Models\Cart::with('product')->where('user_id', auth()->id())->get();
        } else {
            return \App\Models\Cart::with('product')->where('session_id', session()->getId())->get();
        }
    }

    private function getCartCount()
    {
        if (auth()->check()) {
            return \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
        } else {
            return \App\Models\Cart::where('session_id', session()->getId())->sum('quantity');
        }
    }

    private function getCartTotal()
    {
        $items = $this->getCartItems();
        $total = 0;
        foreach($items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $total += $price * $item->quantity;
        }
        return $total;
    }
}
