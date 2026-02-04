<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
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
        $cancellable_statuses = ['pending', 'processing'];
        
        if (!in_array(strtolower($order->status), $cancellable_statuses)) {
            return back()->with('error', 'This order cannot be cancelled as it is already ' . str_replace('_', ' ', $order->status) . '.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Your order has been cancelled successfully.');
    }
    public function wallet()
    {
        $transactions = Auth::user()->transactions()->latest()->paginate(10);
        return view('frontend.profile.wallet', compact('transactions'));
    }
}
