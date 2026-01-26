@extends('admin.layouts.app')

@section('title', 'Create Coupon')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('admin.coupons.index') }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Coupons
        </a>
        <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Create Coupon</h2>
        <p class="text-gray-500 mt-2 text-lg">Define the terms of your new promotional offer.</p>
    </div>

    @if($errors->any())
        <div class="mb-8 p-5 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-2xl shadow-sm">
            <ul class="list-disc list-inside font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-10 lg:p-16">
            <div class="grid grid-cols-1 gap-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Code -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Promo Code</label>
                        <input type="text" name="code" value="{{ old('code') }}" required placeholder="e.g., SEASONAL20" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all uppercase">
                    </div>

                    <!-- Type -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Discount Type</label>
                        <select name="type" required class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                            <option value="fixed">Fixed Amount ($)</option>
                            <option value="percentage">Percentage (%)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Value -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Discount Value</label>
                        <div class="relative">
                             <input type="number" name="value" step="0.01" value="{{ old('value') }}" required placeholder="20.00" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Min Purchase -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Minimum Order Amount</label>
                        <input type="number" name="min_purchase" step="0.01" value="{{ old('min_purchase', 0) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Expiry -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Expiry Date (Optional)</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Usage Limit -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Total Usage Limit</label>
                        <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Leave blank for unlimited" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="inline-flex items-center px-12 py-5 bg-[#1b1b18] hover:bg-black text-white rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] shadow-2xl transition-all hover:-translate-y-1 active:translate-y-0">
                Save Coupon
            </button>
        </div>
    </form>
</div>
@endsection
