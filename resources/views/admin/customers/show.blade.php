@extends('admin.layouts.app')

@section('title', 'Customer History')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10">
        <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Customers
        </a>
        <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">
            {{ $user->name }}
        </h2>
        <p class="text-gray-500 mt-2">Customer history and account details.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 h-fit">
            <h3 class="font-bold text-gray-900 mb-8 border-b border-gray-50 pb-4">Account Information</h3>
            <div class="space-y-6">
                <div>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Email</p>
                    <p class="text-gray-900 font-bold">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Member Since</p>
                    <p class="text-gray-900 font-bold">{{ $user->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="font-bold text-gray-900">Order History</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($user->orders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="px-8 py-6 flex items-center justify-between group hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-6 text-right">
                                <span class="text-sm font-bold text-gray-900">${{ number_format($order->total_price, 2) }}</span>
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">{{ $order->status }}</span>
                                <svg class="w-5 h-5 text-gray-300 transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    @empty
                        <div class="px-8 py-20 text-center text-gray-500 font-medium">
                            This customer hasn't placed any orders yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
