@extends('admin.layouts.app')

@section('title', 'Banner Management')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent tracking-tight">
                Banners
            </h2>
            <p class="text-gray-500 mt-2 text-lg">Create high-impact promotional hero sections for your homepage.</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-1 active:scale-95 group">
            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add New Banner
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-2xl shadow-sm">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Banners Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($banners as $banner)
            <div class="group bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="aspect-[16/9] relative overflow-hidden">
                    <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-8 flex flex-col justify-end">
                        <div class="translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest mb-3">
                                Priority #{{ $banner->order }}
                            </span>
                            <h3 class="text-2xl font-black text-white leading-tight mb-2">{{ $banner->title ?? 'Untitled Banner' }}</h3>
                            <p class="text-white/70 text-sm font-medium line-clamp-1 mb-4">{{ $banner->subtitle }}</p>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6">
                        <span class="flex items-center gap-2 px-4 py-2 rounded-full backdrop-blur-xl border border-white/20 {{ $banner->is_active ? 'bg-emerald-500/90 text-white' : 'bg-rose-500/90 text-white' }} text-[10px] font-black uppercase tracking-widest">
                            <div class="w-2 h-2 rounded-full bg-white {{ $banner->is_active ? 'animate-pulse' : '' }}"></div>
                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="p-8 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="p-4 bg-gray-50 hover:bg-indigo-50 text-indigo-600 rounded-2xl transition-all hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                    </div>
                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Archive this banner?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-4 bg-gray-50 hover:bg-rose-50 text-rose-600 rounded-2xl transition-all hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-[3rem] p-24 text-center border-2 border-dashed border-gray-100">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">No active banners</h3>
                <p class="text-gray-400 font-medium max-w-sm mx-auto mb-8">Light up your store with high-resolution imagery and compelling calls to action.</p>
                <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center text-indigo-600 font-black uppercase tracking-widest text-xs hover:underline decoration-2 underline-offset-8">Create your first banner →</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
