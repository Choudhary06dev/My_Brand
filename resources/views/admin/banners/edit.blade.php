@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Banners
        </a>
        <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Edit Banner</h2>
        <p class="text-gray-500 mt-2 text-lg">Modify the spotlight visual and messaging.</p>
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

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf @method('PUT')
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-10 lg:p-16">
            <div class="grid grid-cols-1 gap-10">
                <!-- Status Toggle -->
                <div class="flex items-center justify-between p-6 bg-gray-50 rounded-3xl border border-gray-100">
                    <div>
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Visibility Status</h4>
                        <p class="text-xs text-gray-400 font-medium">Toggle presence on the homepage</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" class="sr-only peer" value="1" {{ $banner->is_active ? 'checked' : '' }}>
                        <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Master Visual (High Resolution)</label>
                    <div class="group relative aspect-[21/9] rounded-[2rem] bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden transition-all hover:border-indigo-300">
                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" id="imageInput">
                        <img id="imagePreview" src="{{ asset('storage/' . $banner->image) }}" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                             <div class="bg-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest shadow-xl">Replace Imagery</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Title -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Headline</label>
                        <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Button Text -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Action Label</label>
                        <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Subtitle -->
                <div class="space-y-4">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Detailed Context</label>
                    <textarea name="subtitle" rows="3" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">{{ old('subtitle', $banner->subtitle) }}</textarea>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Link -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Target Destination (URL)</label>
                        <input type="text" name="link" value="{{ old('link', $banner->link) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Order -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Presentation Order</label>
                        <input type="number" name="order" value="{{ old('order', $banner->order) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl px-6 py-4 font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="inline-flex items-center px-12 py-5 bg-[#1b1b18] hover:bg-black text-white rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] shadow-2xl transition-all hover:-translate-y-1 active:translate-y-0">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('imageInput').onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            imagePreview.src = URL.createObjectURL(file)
        }
    }
</script>
@endsection
