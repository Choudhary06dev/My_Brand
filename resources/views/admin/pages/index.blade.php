@extends('admin.layouts.app')

@section('title', 'Pages')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            <h2 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent tracking-tight">
                Pages
            </h2>
            <p class="text-gray-500 mt-2 text-lg">Manage your brand's editorial content and legal documents.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-1 active:scale-95 group">
            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add New Page
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-2xl shadow-sm">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Pages List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($pages as $page)
            <div class="group bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 flex items-center justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center text-indigo-600 border border-gray-100 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $page->title }}</h3>
                        <p class="text-xs text-gray-400 font-mono mt-1 italic tracking-widest">{{ '/pages/' . $page->slug }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-8">
                    <span class="flex items-center gap-2 px-4 py-2 rounded-full border {{ $page->is_active ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-gray-50 text-gray-400 border-gray-100' }} text-[10px] font-black uppercase tracking-widest">
                        {{ $page->is_active ? 'Published' : 'Draft' }}
                    </span>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="p-4 bg-gray-50 hover:bg-white hover:shadow-lg text-gray-400 hover:text-indigo-600 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Delete this page permanently?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-4 bg-gray-50 hover:bg-white hover:shadow-lg text-gray-400 hover:text-rose-600 rounded-2xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-[3rem] p-24 text-center border-2 border-dashed border-gray-100">
                <h3 class="text-2xl font-black text-gray-900 mb-2">Build your story</h3>
                <p class="text-gray-400 font-medium mb-8 italic">No custom pages created yet.</p>
                <a href="{{ route('admin.pages.create') }}" class="text-indigo-600 font-black uppercase tracking-widest text-xs hover:underline decoration-2 underline-offset-8">Add first page →</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
