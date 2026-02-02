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
                            <h2 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                                <i class="fas fa-list-ul text-indigo-300"></i>
                                Order Items ({{ $order->items->count() }})
                            </h2>
                            <div class="space-y-8">
                                @foreach($order->items as $item)
                                    <div class="flex gap-8 pb-8 border-b border-gray-50 last:border-0 last:pb-0">
                                        <div class="w-32 h-32 bg-gray-50 rounded-[2rem] overflow-hidden shrink-0 shadow-sm border border-gray-100">
                                            <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                 alt="{{ $item->product->product_name }}"
                                                 class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500"
                                                 onerror="this.src='{{ asset('assets/placeholder.png') }}'">
                                        </div>
                                        <div class="flex-1 py-1">
                                            <h4 class="text-lg font-black text-gray-900 mb-2 leading-tight">{{ $item->product->product_name }}</h4>
                                            <div class="flex flex-wrap gap-3 mb-4">
                                                @if($item->size)
                                                    <span class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 py-1.5 rounded-lg border border-gray-100">
                                                        <i class="fas fa-ruler-combined mr-2 opacity-50"></i>{{ $item->size }}
                                                    </span>
                                                @endif
                                                @if($item->color)
                                                    <span class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest px-3 py-1.5 rounded-lg border border-gray-100">
                                                        <i class="fas fa-palette mr-2 opacity-50"></i>{{ $item->color }}
                                                    </span>
                                                @endif
                                                <span class="bg-indigo-50 text-[10px] font-black text-indigo-400 uppercase tracking-widest px-3 py-1.5 rounded-lg border border-indigo-50">
                                                    <i class="fas fa-box mr-2 opacity-50"></i>QTY: {{ $item->quantity }}
                                                </span>
                                            </div>
                                            <p class="text-xl font-black text-indigo-600">{{ number_format($item->price, 2) }} <span class="text-xs ml-1">{{ $company->currency_symbol ?? 'PKR' }}</span></p>
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
                        <div class="bg-gray-900 rounded-[2rem] p-8 text-white shadow-2xl overflow-hidden relative group">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -mr-16 -mt-16 transition-all group-hover:bg-indigo-500/20"></div>
                            
                            <h2 class="text-lg font-black mb-6 relative z-10">Shipping Details</h2>
                            <div class="space-y-6 relative z-10">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1 opacity-50">Customer Name</p>
                                    <p class="font-bold text-base">{{ $order->first_name }} {{ $order->last_name }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1 opacity-50">Shipping Address</p>
                                    <p class="text-sm font-bold text-gray-300 leading-relaxed">{{ $order->address }}<br>{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1 opacity-50">Payment Method</p>
                                    <p class="font-bold text-indigo-400 uppercase">
                                        @if($order->payment_method === 'cod')
                                            Cash on Delivery
                                        @elseif($order->payment_method === 'stripe')
                                            Credit / Debit Card
                                        @elseif($order->payment_method === 'jazzcash')
                                            JazzCash (Manual)
                                        @elseif($order->payment_method === 'easypaisa')
                                            EasyPaisa (Manual)
                                        @else
                                            {{ str_replace('_', ' ', $order->payment_method) }}
                                        @endif
                                    </p>
                                </div>

                                @if($order->payment_proof)
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-3 opacity-50">Payment Proof Attached</p>
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="block rounded-2xl overflow-hidden border border-white/10 group relative">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Payment Proof" class="w-full h-32 object-cover opacity-60 group-hover:opacity-100 transition-opacity">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/40">
                                            <i class="fas fa-eye text-white text-xl"></i>
                                        </div>
                                    </a>
                                </div>
                                @endif

                                @if(in_array(strtolower($order->status), ['pending', 'processing', 'shipped']))
                                    <div class="pt-6 border-t border-white/10 mt-6">
                                        <form action="{{ route('frontend.profile.order-cancel', $order->order_number) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-2xl font-black text-xs transition-all border border-red-500/20">
                                                <i class="fas fa-times-circle"></i> CANCEL ORDER
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
