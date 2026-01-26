@extends('admin.layouts.app')

@section('title', 'Order Management')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent tracking-tight">
                Orders
            </h2>
            <p class="text-gray-500 mt-2 text-lg">Manage and track your store's sales performance.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-2xl shadow-sm">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 backdrop-blur-sm text-gray-400 text-xs uppercase tracking-[0.1em] font-bold">
                    <tr>
                        <th class="px-8 py-6">Order ID</th>
                        <th class="px-8 py-6">Customer</th>
                        <th class="px-8 py-6">Status</th>
                        <th class="px-8 py-6">Total</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="group hover:bg-indigo-50/30 transition-all duration-300">
                            <td class="px-8 py-6 font-mono text-gray-900 font-bold">
                                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900">{{ $order->user->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'completed' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-rose-100 text-rose-700',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[0.7rem] font-black tracking-widest uppercase {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 font-bold text-gray-900">
                                ${{ number_format($order->total_price, 2) }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="p-3 text-indigo-600 hover:bg-white hover:shadow-lg rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-gray-500 font-medium">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="px-8 py-6 bg-gray-50/50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
