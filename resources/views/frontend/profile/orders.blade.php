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
                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden animate-fade-in">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="px-8 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-center">Date</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">Order ID</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">Items</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <!-- Date -->
                                        <td class="px-8 py-6 text-center">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-gray-900">{{ $order->created_at->format('d M') }}</span>
                                                <span class="text-[9px] font-bold text-gray-400">{{ $order->created_at->format('Y') }}</span>
                                            </div>
                                        </td>

                                        <!-- ID -->
                                        <td class="px-8 py-6">
                                            <span class="text-xs font-black text-gray-900 tracking-tight">#{{ $order->order_number }}</span>
                                        </td>

                                        <!-- Items -->
                                        <td class="px-8 py-6">
                                            <div class="flex -space-x-4">
                                                @foreach($order->items->take(3) as $item)
                                                    <div class="w-10 h-10 rounded-xl overflow-hidden border-2 border-white shadow-sm bg-gray-50 flex-shrink-0">
                                                        <img src="{{ asset('storage/' . ($item->product->main_image ?? 'placeholder.png')) }}" 
                                                             alt="{{ $item->product->product_name }}"
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                @endforeach
                                                @if($order->items->count() > 3)
                                                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-white shadow-sm flex-shrink-0">
                                                        <span class="text-[10px] font-black text-gray-400">+{{ $order->items->count() - 3 }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Amount -->
                                        <td class="px-8 py-6">
                                            <p class="text-xs font-black text-gray-900">
                                                <span class="text-[10px] text-indigo-600 mr-0.5">{{ $company->currency_symbol ?? 'PKR' }}</span>{{ number_format($order->total_amount) }}
                                            </p>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-8 py-6 text-center">
                                            <span class="order-badge badge-{{ strtolower($order->status) }} px-3 py-1 rounded-lg text-[9px] font-black whitespace-nowrap shadow-sm">
                                                {{ strtoupper(trim($order->status)) }}
                                            </span>
                                        </td>

                                        <!-- Action -->
                                        <td class="px-8 py-6 text-right">
                                            <div class="flex justify-end gap-2">
                                                @if(in_array(strtolower($order->status), ['pending', 'confirmed', 'processing']))
                                                    <form action="{{ route('frontend.profile.order-cancel', $order->order_number) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                                        @csrf
                                                        <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-red-500 bg-red-50 hover:bg-red-500 hover:text-white transition-all shadow-sm" title="Cancel Order">
                                                            <i class="fas fa-times text-xs"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if(in_array(strtolower($order->status), ['delivered', 'cancelled', 'refunded']))
                                                    <form action="{{ route('frontend.profile.order-reorder', $order->order_number) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-indigo-500 bg-indigo-50 hover:bg-indigo-500 hover:text-white transition-all shadow-sm" title="Reorder Items">
                                                            <i class="fas fa-redo text-xs"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('frontend.profile.order-detail', $order->order_number) }}" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-900 text-white hover:bg-indigo-600 transition-all shadow-sm" title="View Details">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
@endsection
