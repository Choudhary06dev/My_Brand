@extends('admin.layouts.app')

@section('title', 'Create Banner')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Banners
        </a>
        <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Create Banner</h2>
        <p class="text-gray-500 mt-2 text-lg">Design a new promotional spotlight for your store.</p>
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

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-10 lg:p-16">
            <div class="grid grid-cols-1 gap-10">
                <!-- Image Upload -->
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Master Visual (High Resolution)</label>
                    <div class="group relative aspect-[16/6] rounded-[2rem] bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden transition-all hover:border-indigo-300">
                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" id="imageInput">
                        <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <div class="text-center group-hover:scale-110 transition-transform duration-500">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-500">Drag imagery or click to browse</p>
                            <p class="text-[10px] text-gray-300 font-black uppercase tracking-widest mt-1">PNG, JPG, WebP (Max 5MB)</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Title -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Headline</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., Summer Series 2026" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Button Text -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Action Label</label>
                        <input type="text" name="button_text" value="{{ old('button_text', 'Shop Now') }}" placeholder="e.g., Discover More" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Subtitle -->
                <div class="space-y-4">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Detailed Context</label>
                    <textarea name="subtitle" rows="3" placeholder="A brief description of this promotion..." class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">{{ old('subtitle') }}</textarea>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Link -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Target Destination (URL)</label>
                        <input type="text" name="link" value="{{ old('link') }}" placeholder="/collections/summer-sale" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Order -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Presentation Order</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="inline-flex items-center px-12 py-5 bg-[#1b1b18] hover:bg-black text-white rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] shadow-2xl transition-all hover:-translate-y-1 active:translate-y-0">
                Create Banner
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('imageInput').onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            imagePreview.src = URL.createObjectURL(file)
            imagePreview.classList.remove('hidden')
        }
    }
</script>
@endsection
