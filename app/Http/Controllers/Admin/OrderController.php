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
                'status' => 'required|in:pending,processing,shipped,completed,cancelled,refunded',
                'payment_status' => 'required|in:pending,paid,failed,refunded',
            ]);

            $oldStatus = $order->status;
            
            $updateData = [
                'status' => $request->status,
                'payment_status' => $request->payment_status,
            ];

            if ($request->status === 'completed' && $oldStatus !== 'completed') {
                $updateData['delivered_at'] = now();
            }

            $order->update($updateData);

            $this->logActivity('Update Order', "Updated order #{$order->order_number} status from {$oldStatus} to {$request->status}");

            return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Order Update Failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    public function summaryPage()
    {
        return view('admin.orders.summary');
    }

    public function getOrderSummary(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = Order::with('items.product')->where('status', 'completed');
        
        // Apply date filters
        switch ($filter) {
            case 'weekly':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'monthly':
                $query->where('created_at', '>=', now()->subMonth());
                break;
            case 'yearly':
                $query->where('created_at', '>=', now()->subYear());
                break;
            case 'all':
            default:
                // No date filter
                break;
        }
        
        $orders = $query->get();
        
        $totalPurchaseCost = 0;
        $totalSales = 0;
        $totalProfit = 0;
        $productStats = [];
        
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $totalPurchaseCost += $item->total_purchase_cost;
                $totalSales += $item->total_sale;
                $totalProfit += $item->profit;
                
                // Aggregate product statistics
                $productId = $item->product_id;
                if (!isset($productStats[$productId])) {
                    $productStats[$productId] = [
                        'name' => $item->product?->product_name ?? 'Unknown Product',
                        'quantity' => 0,
                        'total_sale' => 0,
                        'total_cost' => 0,
                        'total_profit' => 0,
                    ];
                }
                
                $productStats[$productId]['quantity'] += $item->quantity;
                $productStats[$productId]['total_sale'] += $item->total_sale;
                $productStats[$productId]['total_cost'] += $item->total_purchase_cost;
                $productStats[$productId]['total_profit'] += $item->profit;
            }
        }
        
        // Sort products by quantity sold (descending)
        usort($productStats, function($a, $b) {
            return $b['quantity'] - $a['quantity'];
        });
        
        $profitMargin = $totalSales > 0 ? ($totalProfit / $totalSales) * 100 : 0;
        
        return response()->json([
            'total_purchase_cost' => number_format($totalPurchaseCost, 2),
            'total_sales' => number_format($totalSales, 2),
            'total_profit' => number_format($totalProfit, 2),
            'profit_margin' => number_format($profitMargin, 2),
            'order_count' => $orders->count(),
            'filter' => $filter,
            'products' => array_map(function($product) {
                return [
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'total_sale' => number_format($product['total_sale'], 2),
                    'total_cost' => number_format($product['total_cost'], 2),
                    'total_profit' => number_format($product['total_profit'], 2),
                ];
            }, $productStats),
        ]);
    }

    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;
        $order->delete();
        $this->logActivity('Delete Order', "Deleted order #{$orderNumber}");
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
