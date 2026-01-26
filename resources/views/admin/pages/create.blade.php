@extends('admin.layouts.app')

@section('title', 'Create Page')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Pages
        </a>
        <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Create Page</h2>
        <p class="text-gray-500 mt-2 text-lg">Draft new content for your brand's digital presence.</p>
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

    <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Editor -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-10 lg:p-16">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Page Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., Our Sustainability Promise" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 text-2xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-200">
                        </div>

                        <div class="space-y-4">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Body Content</label>
                            <textarea name="content" rows="15" required placeholder="Write your story here..." class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-medium text-gray-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO & Sidebar -->
            <div class="space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                    <h3 class="font-bold text-gray-900 mb-8 border-b border-gray-50 pb-4">SEO Optimization</h3>
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold text-gray-700 outline-none focus:bg-white">
                        </div>
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Meta Description</label>
                            <textarea name="meta_description" rows="4" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none focus:bg-white">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-[#1b1b18] rounded-[2.5rem] shadow-2xl p-10">
                    <div class="space-y-8 text-center">
                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <p class="text-white/50 text-[10px] font-black uppercase tracking-[0.2em]">Ready to Save?</p>
                        <button type="submit" class="w-full bg-white hover:bg-indigo-50 text-black px-10 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] shadow-2xl transition-all transform hover:-translate-y-1">
                            Save Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
