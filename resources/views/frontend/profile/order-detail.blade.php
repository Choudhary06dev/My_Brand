@extends('frontend.layouts.app')

@section('title', 'Order Details #' . $order->order_number . ' - ' . config('app.name'))

@push('styles')
<style>
    .order-tracker {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        padding: 2rem 0;
    }
    .tracker-line {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 4px;
        background: #f1f5f9;
        z-index: 1;
        transform: translateY(-50%);
    }
    .tracker-progress {
        position: absolute;
        top: 50%;
        left: 0;
        height: 4px;
        background: var(--accent-1);
        z-index: 2;
        transform: translateY(-50%);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .tracker-step {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
    }
    .step-icon {
        width: 48px;
        height: 48px;
        background: white;
        border: 4px solid #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #94a3b8;
        transition: all 0.4s ease;
    }
    .tracker-step.active .step-icon {
        border-color: var(--accent-1);
        color: var(--accent-1);
        box-shadow: 0 0 20px rgba(var(--accent-1-rgb), 0.2);
    }
    .tracker-step.completed .step-icon {
        background: var(--accent-1);
        border-color: var(--accent-1);
        color: white;
    }
    .step-label {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        transition: color 0.4s ease;
    }
    .tracker-step.active .step-label,
    .tracker-step.completed .step-label {
        color: #1e293b;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .item-card {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    .item-card:hover {
        transform: translateX(10px);
        border-color: rgba(var(--accent-1-rgb), 0.1);
        background: rgba(255, 255, 255, 1);
    }
</style>
@endpush

@section('content')
@php
    $statuses = [
        'pending'    => ['icon' => 'fa-clock', 'label' => 'Pending'],
        'processing' => ['icon' => 'fa-cog', 'label' => 'Processing'],
        'shipped'    => ['icon' => 'fa-shipping-fast', 'label' => 'Shipped'],
        'completed'  => ['icon' => 'fa-check-double', 'label' => 'Completed']
    ];
    $statusKeys = array_keys($statuses);
    $currentStatus = strtolower($order->status);
    if ($currentStatus === 'refunded') {
        // Keep 'Completed' label, just mark it as the final step
        $statusIndex = 3; // Index of 'completed'
    } else {
        $statusIndex = array_search($currentStatus, $statusKeys);
    }
    if($statusIndex === false && $currentStatus == 'cancelled') $statusIndex = -1;
    $progressWidth = $statusIndex >= 0 ? ($statusIndex / (count($statusKeys) - 1)) * 100 : 0;
@endphp

<section class="py-12 bg-[#fcfcfd]">
    <div class="container-custom">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <a href="{{ route('frontend.profile.orders') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition-colors mb-4 gap-2">
                        <i class="fas fa-arrow-left"></i> BACK TO ORDERS
                    </a>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">Order Details</h1>
                    <p class="text-gray-500 mt-2 font-medium flex items-center gap-3">
                        <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-black text-gray-600">ID: #{{ $order->order_number }}</span>
                        <span>Placed on {{ $order->created_at->format('M d, Y') }}</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    @if(in_array(strtolower($order->status), ['pending', 'processing']))
                        <form action="{{ route('frontend.profile.order-cancel', $order->order_number) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf
                            <button type="submit" class="group flex items-center gap-3 px-6 py-3 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl font-black text-xs transition-all border border-red-100">
                                <i class="fas fa-times-circle group-hover:rotate-90 transition-transform"></i> CANCEL ORDER
                            </button>
                        </form>
                    @endif
                    @if($order->isReturnable())
                        <a href="{{ route('frontend.profile.order-return', $order->order_number) }}" class="flex items-center gap-3 px-6 py-3 bg-indigo-600 text-white hover:bg-indigo-700 rounded-2xl font-black text-xs transition-all shadow-lg shadow-indigo-200">
                            <i class="fas fa-undo"></i> RETURN ORDER
                        </a>
                    @endif
                </div>
            </div>

            <!-- Order Tracker -->
            @if($currentStatus !== 'cancelled')
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 mb-12">
                <div class="order-tracker">
                    <div class="tracker-line"></div>
                    <div class="tracker-progress" style="width: {{ $progressWidth }}%"></div>
                    
                    @foreach($statusKeys as $index => $statusKey)
                        <div class="tracker-step {{ $index < $statusIndex ? 'completed' : ($index == $statusIndex ? 'active' : '') }}">
                            <div class="step-icon">
                                @if($index < $statusIndex)
                                    <i class="fas fa-check"></i>
                                @else
                                    <i class="fas {{ $statuses[$statusKey]['icon'] }}"></i>
                                @endif
                            </div>
                            <span class="step-label">{{ $statuses[$statusKey]['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-red-50 rounded-[2.5rem] p-8 border border-red-100 mb-12 flex items-center gap-6">
                <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-times"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-red-900">Order Cancelled</h3>
                    <p class="text-red-700 font-medium">This order was cancelled on {{ $order->updated_at->format('M d, Y') }}.</p>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Left Column: Items -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-10">
                            <h2 class="text-2xl font-black text-gray-900 flex items-center gap-4">
                                <span class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-sm">
                                    <i class="fas fa-shopping-bag"></i>
                                </span>
                                Order Items
                            </h2>
                            <span class="text-sm font-black text-gray-400 uppercase tracking-widest">{{ $order->items->count() }} {{ $order->items->count() > 1 ? 'Items' : 'Item' }}</span>
                        </div>

                        <div class="space-y-6">
                            @foreach($order->items as $item)
                                <div class="item-card flex gap-8 p-4 rounded-[2rem] bg-gray-50/50">
                                    <div class="w-32 h-32 bg-white rounded-3xl overflow-hidden shrink-0 shadow-sm border border-gray-100 relative group">
                                        <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                             alt="{{ $item->product->product_name }}"
                                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                             onerror="this.src='{{ asset('assets/placeholder.png') }}'">
                                    </div>
                                    <div class="flex-1 py-2 flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-xl font-black text-gray-900 mb-2 leading-tight">{{ $item->product->product_name }}</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @if($item->size)
                                                    <span class="bg-white text-[10px] font-black text-gray-500 uppercase tracking-widest px-3 py-1.5 rounded-xl border border-gray-100 flex items-center gap-2">
                                                        <i class="fas fa-ruler-combined text-indigo-300"></i>{{ $item->size }}
                                                    </span>
                                                @endif
                                                @if($item->color)
                                                    <span class="bg-white text-[10px] font-black text-gray-500 uppercase tracking-widest px-3 py-1.5 rounded-xl border border-gray-100 flex items-center gap-2">
                                                        <i class="fas fa-palette text-indigo-300"></i>{{ $item->color }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mt-4">
                                            <p class="text-sm font-bold text-gray-400">Qty: <span class="text-gray-900">{{ $item->quantity }}</span></p>
                                            <p class="text-2xl font-black text-indigo-600">{{ number_format($item->price, 2) }} <span class="text-xs ml-1">{{ $company->currency_symbol ?? 'PKR' }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Additional Info / Timeline if needed -->
                    @if($order->returnRequests()->where('status', '!=', 'rejected')->exists())
                        @php $returnReq = $order->returnRequests->first(); @endphp
                        <div class="bg-amber-50 rounded-[2.5rem] p-8 border border-amber-100 flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <div class="w-12 h-12 bg-amber-500 text-white rounded-full flex items-center justify-center text-xl">
                                    <i class="fas fa-undo"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-black text-amber-900 uppercase tracking-tight">Return Information</h4>
                                    <p class="text-amber-700 font-medium">Request Status: {{ strtoupper($returnReq->status) }}</p>
                                </div>
                            </div>
                            <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border 
                                {{ $returnReq->status === 'refunded' ? 'bg-green-500/10 text-green-600 border-green-500/20' : 
                                   ($returnReq->status === 'approved' ? 'bg-indigo-500/10 text-indigo-600 border-indigo-500/20' : 
                                   'bg-amber-500/10 text-amber-600 border-amber-500/20') }}">
                                {{ str_replace('_', ' ', $returnReq->status) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Summary & Info -->
                <div class="space-y-8">
                    <!-- Summary Card -->
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-black text-gray-900 mb-8">Order Summary</h2>
                        <div class="space-y-5">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Subtotal</span>
                                <span class="font-black text-gray-900">{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Shipping</span>
                                <span class="font-black text-gray-900">{{ number_format($order->shipping_cost, 2) }}</span>
                            </div>
                            <div class="pt-6 border-t border-gray-50 flex justify-between items-center mt-6">
                                <span class="font-black text-gray-900 text-lg">Total Amount</span>
                                <div class="text-right">
                                    <span class="block text-3xl font-black text-indigo-600">{{ number_format($order->total_amount, 2) }}</span>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $company->currency_symbol ?? 'PKR' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Info Card -->
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden text-white group">
                        <!-- Decorative background element -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl transition-transform group-hover:scale-150 duration-1000"></div>
                        
                        <h2 class="text-xl font-black mb-10 relative z-10 flex items-center gap-4">
                            <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-sm">
                                <i class="fas fa-shipping-fast text-indigo-400"></i>
                            </span>
                            Logistics
                        </h2>
                        
                        <div class="space-y-8 relative z-10">
                            <div class="flex gap-4">
                                <div class="w-1.5 bg-indigo-500 rounded-full"></div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1.5 opacity-60">Recipient</p>
                                    <p class="font-bold text-lg leading-tight">{{ $order->first_name }} {{ $order->last_name }}</p>
                                    <p class="text-sm text-gray-400 mt-1">{{ $order->email }}</p>
                                    <p class="text-sm text-gray-400">{{ $order->phone }}</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-1.5 bg-indigo-500/30 rounded-full"></div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1.5 opacity-60">Shipping Address</p>
                                    <p class="text-sm font-medium text-gray-300 leading-relaxed">{{ $order->address }}</p>
                                    <p class="text-sm font-black text-white mt-1 uppercase tracking-tight">{{ $order->city }}, {{ $order->state }}</p>
                                    <p class="text-sm text-indigo-400 font-bold mt-1">Zip: {{ $order->zip_code }}</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-1.5 bg-indigo-500/10 rounded-full"></div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1.5 opacity-60">Payment via</p>
                                    <div class="flex items-center gap-3">
                                        <p class="font-black text-indigo-400 uppercase tracking-wider text-sm">
                                            @if($order->payment_method === 'cod')
                                                Cash on Delivery
                                            @else
                                                {{ str_replace('_', ' ', $order->payment_method) }}
                                            @endif
                                        </p>
                                        <span class="w-2 h-2 rounded-full {{ $order->payment_status == 'paid' ? 'bg-green-500' : 'bg-red-500 animate-pulse' }}"></span>
                                    </div>
                                </div>
                            </div>

                            @if($order->payment_proof)
                            <div class="pt-4">
                                <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-4 opacity-60">Payment Proof</p>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="block group/proof relative rounded-2xl overflow-hidden border border-white/10">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Payment Proof" class="w-full h-32 object-cover opacity-50 group-hover/proof:opacity-100 group-hover/proof:scale-110 transition-all duration-700">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover/proof:opacity-100 transition-opacity">
                                        <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/20">View Document</span>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
