@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent tracking-tight">
                Coupons
            </h2>
            <p class="text-gray-500 mt-2 text-lg">Manage promotional codes and special discounts.</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-1 active:scale-95 group">
            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Create Coupon
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-2xl shadow-sm">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Coupons Table -->
    <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 backdrop-blur-sm text-gray-400 text-xs uppercase tracking-[0.1em] font-bold">
                    <tr>
                        <th class="px-8 py-6">Code</th>
                        <th class="px-8 py-6">Value</th>
                        <th class="px-8 py-6">Usage</th>
                        <th class="px-8 py-6">Expiry</th>
                        <th class="px-8 py-6 text-center">Status</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($coupons as $coupon)
                        <tr class="group hover:bg-indigo-50/30 transition-all duration-300">
                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-900 rounded-lg font-mono font-bold uppercase tracking-wider text-sm border border-gray-200 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-500 transition-all">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-black text-gray-900">
                                        {{ $coupon->type == 'percentage' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2) }}
                                    </span>
                                    <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mt-0.5">
                                        Min {{ '$' . number_format($coupon->min_purchase, 2) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900">{{ $coupon->usage_count }} / {{ $coupon->usage_limit ?? '∞' }}</span>
                                    <div class="w-20 h-1 bg-gray-100 rounded-full mt-2 overflow-hidden">
                                        @php
                                            $percent = $coupon->usage_limit ? ($coupon->usage_count / $coupon->usage_limit) * 100 : 0;
                                        @endphp
                                        <div class="h-full bg-indigo-500" style="width: {{ min($percent, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-sm font-medium text-gray-500">
                                {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[0.7rem] font-black tracking-widest uppercase {{ $coupon->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="p-3 text-indigo-600 hover:bg-white hover:shadow-lg rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-gray-500 font-medium font-bold">
                                No coupons discovered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($coupons->hasPages())
            <div class="px-8 py-6 bg-gray-50/50">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
