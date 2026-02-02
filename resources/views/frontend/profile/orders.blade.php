@extends('frontend.layouts.app')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<div class="bg-gray-50/50 min-h-screen py-12">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Order History</h1>
                    <p class="text-sm text-gray-500 font-medium">Manage and track your recent purchases.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="px-3 py-1.5 bg-white rounded-xl border border-gray-100 shadow-sm flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-gray-700">Systems Active</span>
                    </div>
                </div>
            </div>

            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-lg shadow-gray-200/20 overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:shadow-indigo-100/30 group animate-fade-in" style="animation-delay: {{ $loop->index * 100 }}ms">
                            <!-- Order Info Bar -->
                            <div class="px-6 py-3 bg-gray-50/50 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Order ID</span>
                                        <span class="text-sm font-black text-gray-900">#{{ $order->order_number }}</span>
                                    </div>
                                    <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Date Placed</span>
                                        <span class="text-xs font-bold text-gray-700">{{ $order->created_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="order-badge badge-{{ strtolower($order->status) }} px-4 py-1.5 rounded-xl text-[10px] font-black shadow-sm">
                                        <i class="fas fa-circle text-[5px] mr-1.5 opacity-60"></i> {{ strtoupper($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                    <!-- Items Preview -->
                                    <div class="lg:col-span-8">
                                        <div class="flex flex-wrap items-center gap-3">
                                            @foreach($order->items->take(4) as $item)
                                                <div class="relative group/item">
                                                    <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-white shadow-md bg-gray-50 group-hover/item:scale-110 transition-transform duration-300">
                                                        <img src="{{ asset('storage/' . ($item->product->main_image ?? 'placeholder.png')) }}" 
                                                             alt="{{ $item->product->product_name }}"
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                    @if($item->quantity > 1)
                                                        <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-[9px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-lg">
                                                            {{ $item->quantity }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 4)
                                                <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center border-2 border-white shadow-md">
                                                    <span class="text-[10px] font-black text-gray-400">+{{ $order->items->count() - 4 }}</span>
                                                </div>
                                            @endif
                                            @if($order->items->count() == 1)
                                                <div class="ml-1">
                                                    <h4 class="text-xs font-black text-gray-900 truncate max-w-[150px] leading-tight">{{ $order->items->first()->product->product_name }}</h4>
                                                    <p class="text-[10px] text-gray-400 font-bold">and more inside</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Price & Actions -->
                                    <div class="lg:col-span-4 flex flex-col justify-between items-end gap-4 text-right">
                                        <div class="space-y-0.5">
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Grand Total</span>
                                            <p class="text-xl font-black text-gray-900 tracking-tight">
                                                <span class="text-xs text-indigo-600 mr-0.5">{{ $company->currency_symbol ?? 'PKR' }}</span>{{ number_format($order->total_amount) }}
                                            </p>
                                        </div>
                                        
                                        <div class="flex flex-wrap justify-end gap-2 w-full">
                                            @if(in_array(strtolower($order->status), ['pending', 'processing', 'shipped']))
                                                <form action="{{ route('frontend.profile.order-cancel', $order->order_number) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2.5 rounded-xl text-[10px] font-black text-red-500 bg-red-50 hover:bg-red-100 border border-red-200/30 transition-all flex items-center gap-1.5">
                                                        <i class="fas fa-times-circle"></i> CANCEL
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('frontend.profile.order-detail', $order->order_number) }}" class="flex-1 lg:flex-none inline-flex items-center justify-center px-6 py-2.5 bg-gray-900 text-white hover:bg-indigo-600 rounded-xl font-black text-[11px] tracking-wide transition-all duration-300 shadow-lg shadow-gray-200/50 hover:shadow-indigo-200/40">
                                                VIEW DETAILS <i class="fas fa-arrow-right ml-2 text-[9px] transition-transform group-hover:translate-x-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tracking Bar (Subtle) -->
                            <div class="px-6 py-2 bg-gray-50/20 border-t border-gray-50 flex items-center justify-between">
                                <span class="text-[9px] font-extrabold text-gray-400 uppercase tracking-wider">
                                    {{ str_replace('_', ' ', $order->payment_status) }} • 
                                    @if($order->payment_method === 'cod')
                                        Cash on Delivery
                                    @elseif($order->payment_method === 'stripe')
                                        Credit Card
                                    @elseif($order->payment_method === 'jazzcash')
                                        JazzCash
                                    @elseif($order->payment_method === 'easypaisa')
                                        EasyPaisa
                                    @else
                                        {{ str_replace('_', ' ', $order->payment_method) }}
                                    @endif
                                </span>
                                <div class="flex items-center gap-1">
                                    @for($i = 0; $i < 4; $i++)
                                        <div class="w-6 h-1 rounded-full {{ $i <= array_search(strtolower($order->status), ['pending', 'processing', 'shipped', 'out_for_delivery', 'completed']) ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-16 text-center shadow-2xl shadow-gray-200/50 border border-gray-100 flex flex-col items-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mb-6 relative">
                        <i class="fas fa-shopping-bag text-4xl text-indigo-400"></i>
                        <span class="absolute top-0 right-0 w-6 h-6 bg-red-500 rounded-full border-4 border-white"></span>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 mb-3">No Orders Found</h2>
                    <p class="text-sm text-gray-500 mb-8 max-w-sm font-medium leading-relaxed">It seems you haven't started your fashion journey with us yet.</p>
                    <a href="{{ route('frontend.products') }}" class="inline-flex items-center px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 hover:scale-105 transform">
                        BROWSE COLLECTION <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
        </div>
    </div>
</div>
@endsection
