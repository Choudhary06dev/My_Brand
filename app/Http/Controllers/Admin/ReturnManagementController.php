<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ReturnRequest;

class ReturnManagementController extends Controller
{
    public function index()
    {
        $requests = ReturnRequest::with(['user', 'order'])->latest()->paginate(10);
        return view('admin.returns.index', compact('requests'));
    }

    public function show($id)
    {
        $request = ReturnRequest::with(['user', 'order.items.product'])->findOrFail($id);
        return view('admin.returns.show', compact('request'));
    }

    public function updateStatus(Request $request, $id)
    {
        \Illuminate\Support\Facades\Log::info("UpdateStatus Called for ID: $id");
        $returnRequest = ReturnRequest::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,qc_in_progress,refunded',
            'admin_remark' => 'nullable|string',
        ]);

        \Illuminate\Support\Facades\Log::info("Status Requested: " . $request->status);

        $returnRequest->update([
            'status' => $request->status,
            'admin_remark' => $request->admin_remark,
        ]);

        // If status is refunded, update order status and payment status
        if ($request->status === 'refunded') {
            \Illuminate\Support\Facades\Log::info("Status is REFUNDED - Proceeding");
            $order = $returnRequest->order;
            
            // 1. Ensure order is updated
            if ($order->payment_status !== 'refunded') {
                $order->update([
                    'status' => 'refunded',
                    'payment_status' => 'refunded'
                ]);
            }

            // 2. Process Wallet Refund (if not already done)
            $user = $returnRequest->user;
            \Illuminate\Support\Facades\Log::info("User found: " . ($user ? $user->id : 'NO'));
            if ($user && $order) {
                // Check if this return request has already been refunded to wallet
                $existingTransaction = $user->transactions()
                    ->where('reference_id', $returnRequest->id) // Use ReturnRequest ID as reference
                    ->orWhere(function ($query) use ($order) {
                         // Fallback check: older implementation used order_id
                         $query->where('reference_id', $order->id)
                               ->where('type', 'credit')
                               ->where('description', 'like', '%Refund for Order%');
                    })
                    ->first();
                
                \Illuminate\Support\Facades\Log::info("Existing Transaction: " . ($existingTransaction ? 'YES' : 'NO'));

                if (!$existingTransaction) {
                    $refundAmount = $order->total_amount;
                    \Illuminate\Support\Facades\Log::info("Crediting Wallet: $refundAmount");
                    // Use ReturnRequest ID as reference for uniqueness tracking
                    $user->creditWallet($refundAmount, "Refund for Order #{$order->order_number}", $returnRequest->id);
                }
            }
        } else {
            \Illuminate\Support\Facades\Log::info("Status NOT refunded: " . $request->status);
        }

        return redirect()->route('admin.returns.index')->with('success', 'Return request status updated successfully.');
    }
}
