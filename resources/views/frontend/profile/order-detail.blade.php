@extends('frontend.layouts.app')

@section('title', 'Order Details #' . $order->order_number . ' - ' . config('app.name'))

@section('content')
<section class="profile-section">
    <div class="container-custom">
        <div class="max-w-6xl mx-auto">
            <!-- Main Content -->
            <div class="profile-main">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-black text-gray-900 mb-2">Order #{{ $order->order_number }}</h1>
                        <p class="text-gray-500">Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}</p>
                    </div>
                    <div class="order-status">
                        <span class="order-badge badge-{{ strtolower($order->status) }} px-6 py-2 text-sm">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Items List -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-50">
                            <h2 class="text-lg font-black text-gray-900 mb-6">Order Items ({{ $order->items->count() }})</h2>
                            <div class="space-y-6">
                                @foreach($order->items as $item)
                                    <div class="flex gap-6 pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                                        <div class="w-24 h-24 bg-gray-50 rounded-2xl overflow-hidden shrink-0">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->product_name }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-base font-bold text-gray-900 mb-1">{{ $item->product->product_name }}</h4>
                                            <div class="flex flex-wrap gap-4 text-xs font-bold text-gray-400 mb-3">
                                                @if($item->size)
                                                    <span class="bg-gray-50 px-2 py-1 rounded">SIZE: {{ $item->size }}</span>
                                                @endif
                                                @if($item->color)
                                                    <span class="bg-gray-50 px-2 py-1 rounded">COLOR: {{ $item->color }}</span>
                                                @endif
                                                <span class="bg-gray-50 px-2 py-1 rounded">QTY: {{ $item->quantity }}</span>
                                            </div>
                                            <p class="text-indigo-600 font-black">{{ number_format($item->price, 2) }} {{ $company->currency_symbol ?? 'PKR' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="space-y-6">
                        <!-- Summary Card -->
                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-50">
                            <h2 class="text-lg font-black text-gray-900 mb-6">Summary</h2>
                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-bold">Subtotal</span>
                                    <span class="font-black text-gray-900">{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-bold">Shipping</span>
                                    <span class="font-black text-gray-900">{{ number_format($order->shipping_cost, 2) }}</span>
                                </div>
                                <div class="pt-4 border-t border-gray-50 flex justify-between items-center text-lg">
                                    <span class="font-black text-gray-900">Total</span>
                                    <span class="font-black text-indigo-600">{{ number_format($order->total_amount, 2) }} {{ $company->currency_symbol ?? 'PKR' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Logistics Card -->
                        <div class="bg-gray-900 rounded-[2rem] p-8 text-white shadow-2xl">
                            <h2 class="text-lg font-black mb-6">Shipping Details</h2>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Customer Name</p>
                                    <p class="font-bold">{{ $order->first_name }} {{ $order->last_name }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Shipping Address</p>
                                    <p class="text-sm font-bold text-gray-300 leading-relaxed">{{ $order->address }}<br>{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Payment Method</p>
                                    <p class="font-bold text-indigo-400 uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
