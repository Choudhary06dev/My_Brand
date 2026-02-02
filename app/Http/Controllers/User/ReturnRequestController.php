<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;

class ReturnRequestController extends Controller
{
    public function showRequestForm($order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$order->isReturnable()) {
            return redirect()->back()->with('error', 'This order is not eligible for return.');
        }

        return view('frontend.profile.return-form', compact('order'));
    }

    public function storeRequest(Request $request, $order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$order->isReturnable()) {
            return redirect()->back()->with('error', 'This order is not eligible for return.');
        }

        $request->validate([
            'reason' => 'required|string',
            'description' => 'required|string|min:10',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('returns', 'public');
                $imagePaths[] = $path;
            }
        }

        ReturnRequest::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'reason' => $request->reason,
            'description' => $request->description,
            'images' => $imagePaths,
            'status' => 'pending',
        ]);

        return redirect()->route('frontend.profile.order-detail', $order_number)
            ->with('success', 'Your return request has been submitted successfully.');
    }
}
