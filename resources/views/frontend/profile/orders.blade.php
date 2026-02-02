@extends('frontend.layouts.app')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<section class="profile-section">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <!-- Main Content -->
            <div class="profile-main">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-gray-900 mb-2">Order History</h1>
                    <p class="text-gray-500">Track and manage your recent orders.</p>
                </div>

                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <div class="order-card animate-fade-in" style="animation-delay: {{ $loop->index * 100 }}ms">
                            <div class="order-header">
                                <div class="order-info">
                                    <h3>Order #{{ $order->order_number }}</h3>
                                    <p class="order-date">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="order-status">
                                    <span class="order-badge badge-{{ strtolower($order->status) }}">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="order-body">
                                <div class="order-items-preview">
                                    @foreach($order->items->take(4) as $item)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->product_name }}"
                                                 class="item-thumbnail"
                                                 onerror="this.src='{{ asset('assets/placeholder.png') }}'">
                                            @if($item->quantity > 1)
                                                <span class="absolute -top-2 -right-2 bg-gray-900 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white">
                                                    {{ $item->quantity }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                    
                                    @if($order->items->count() > 4)
                                        <div class="w-[60px] h-[60px] rounded-xl bg-gray-50 flex items-center justify-center border-2 border-dashed border-gray-200">
                                            <span class="text-xs font-bold text-gray-400">+{{ $order->items->count() - 4 }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="order-summary-row">
                                <div class="text-sm">
                                    <span class="text-gray-500 mr-2">Payment:</span>
                                    <span class="font-bold text-gray-700 uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest leading-none mb-1">Total Amount</p>
                                        <p class="order-total">{{ number_format($order->total_amount, 2) }} {{ $company->currency_symbol ?? 'PKR' }}</p>
                                    </div>
                                    <a href="{{ route('frontend.profile.order-detail', $order->order_number) }}" class="px-6 py-3 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl font-bold text-sm transition-all duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-[2.5rem] p-12 text-center shadow-sm border border-gray-50">
                        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-shopping-bag text-4xl text-indigo-300"></i>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 mb-3">No Orders Yet</h2>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto">You haven't placed any orders yet. Start exploring our collection and make your first purchase!</p>
                        <a href="{{ route('frontend.products') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
                            Start Shopping <i class="fas fa-arrow-right ml-3"></i>
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection
