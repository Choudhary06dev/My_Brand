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
        $returnRequest = ReturnRequest::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,qc_in_progress,refunded',
            'admin_remark' => 'nullable|string',
        ]);

        $returnRequest->update([
            'status' => $request->status,
            'admin_remark' => $request->admin_remark,
        ]);

        // If status is refunded, update order status and payment status
        if ($request->status === 'refunded') {
            $returnRequest->order->update([
                'status' => 'refunded',
                'payment_status' => 'refunded'
            ]);
        }

        return redirect()->route('admin.returns.index')->with('success', 'Return request status updated successfully.');
    }
}
