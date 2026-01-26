@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            @if($parentCategory)
                <a href="{{ route('admin.categories.index', ['parent_id' => $parentCategory->parent_id]) }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group text-sm font-bold uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back
                </a>
            @endif
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent tracking-tight">
                {{ $parentCategory ? $parentCategory->name : 'Categories' }}
            </h2>
            <p class="text-gray-500 mt-2 text-lg">
                {{ $parentCategory ? 'Management of sub-categories for ' . $parentCategory->name : 'Manage your product categories.' }}
            </p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categories.create', ['parent_id' => $parentCategory?->id]) }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-xl shadow-xl shadow-indigo-600/20 font-bold transition-all transform hover:-translate-y-1 active:scale-95 group">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-xl shadow-sm">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Base Table -->
    <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 backdrop-blur-sm text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-6">Identity</th>
                        <th class="px-8 py-6">Description</th>
                        <th class="px-8 py-6 text-center">Status</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php
                        $items = $categories->count() > 0 ? $categories : $products;
                    @endphp

                    @forelse($items as $item)
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="relative w-14 h-14 rounded-xl bg-gray-50 overflow-hidden border-2 border-white shadow-md group-hover:scale-105 transition-transform duration-300">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-200">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        @if($item instanceof \App\Models\Category)
                                            @if(!$parentCategory)
                                                <a href="{{ route('admin.categories.index', ['parent_id' => $item->id]) }}" class="font-bold text-gray-900 text-lg hover:text-indigo-600 transition-all">
                                                    {{ $item->name }}
                                                    @if($item->children()->count() > 0)
                                                        <span class="ml-2 px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] rounded-full uppercase">{{ $item->children()->count() }} sub</span>
                                                    @endif
                                                </a>
                                            @else
                                                <span class="font-bold text-gray-900 text-lg">
                                                    {{ $item->name }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="font-bold text-gray-900 text-lg">{{ $item->name }}</span>
                                        @endif
                                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $item->slug ?? $item->sku }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 max-w-xs">
                                <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                                    {{ $item->description ?? 'No description.' }}
                                </p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-gray-50 text-gray-500 border-gray-100' }}">
                                    {{ $item->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3 transition-all">
                                    <a href="{{ route($item instanceof \App\Models\Category ? 'admin.categories.edit' : 'admin.products.edit', $item) }}" class="p-3 text-indigo-600 hover:bg-white hover:shadow-lg rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs italic">No items found here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @php
            $paginationItems = $categories->count() > 0 ? $categories : $products;
            $hasPages = method_exists($paginationItems, 'hasPages') && $paginationItems->hasPages();
        @endphp

        @if($hasPages)
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $paginationItems->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
