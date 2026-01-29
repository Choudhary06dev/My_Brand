<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,processing,completed,cancelled,refunded',
                'payment_status' => 'required|in:pending,paid,failed,refunded',
            ]);

            $oldStatus = $order->status;
            
            $order->update([
                'status' => $request->status,
                'payment_status' => $request->payment_status,
            ]);

            $this->logActivity('Update Order', "Updated order #{$order->order_number} status from {$oldStatus} to {$request->status}");

            return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Order Update Failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;
        $order->delete();
        $this->logActivity('Delete Order', "Deleted order #{$orderNumber}");
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
