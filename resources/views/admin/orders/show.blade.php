@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Orders
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                    Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </h2>
                <p class="text-gray-500 mt-2">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center gap-4">
                @csrf @method('PATCH')
                <select name="status" class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 font-bold text-sm focus:ring-4 focus:ring-indigo-500/10 outline-none">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    Update Status
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-2xl shadow-sm">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="font-bold text-gray-900">Order Items</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($order->orderItems as $item)
                        <div class="px-8 py-6 flex items-center justify-between group">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-20 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-400">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-gray-900">${{ number_format($item->quantity * $item->price, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="px-8 py-6 bg-gray-50/30 border-t border-gray-50 flex justify-between items-center">
                    <span class="text-gray-500 font-bold uppercase tracking-widest text-xs">Total Amount</span>
                    <span class="text-2xl font-black text-gray-900">${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Order Sidebar -->
        <div class="space-y-8">
            <!-- Customer Info -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Customer Details
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Name</p>
                        <a href="{{ route('admin.customers.show', $order->user) }}" class="text-gray-900 font-bold hover:text-indigo-600 transition-colors">
                            {{ $order->user->name }}
                        </a>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Email</p>
                        <p class="text-gray-900 font-medium">{{ $order->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Shipping Address
                </h3>
                <p class="text-gray-600 font-medium leading-relaxed whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
