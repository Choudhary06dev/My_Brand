@extends('admin.layouts.app')

@section('title', 'Add New Category')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-gray-400 hover:text-indigo-600 transition-all mb-4 group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Categories
        </a>
        <h2 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent tracking-tight">
            Add New Category
        </h2>
        <p class="text-gray-500 mt-2 text-lg">Create a new category for your products.</p>
    </div>

    @if($errors->any())
        <div class="mb-8 p-5 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-2xl shadow-sm">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden relative">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="p-10 relative">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Left Side -->
                <div class="space-y-8">
                    <div>
                        <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-3">Parent Collection (Optional)</label>
                        <select name="parent_id" id="parent_id" class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-8 focus:ring-indigo-500/5 transition-all outline-none text-gray-800 font-bold appearance-none cursor-pointer">
                            <option value="">Top Level Collection</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">Category Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-8 focus:ring-indigo-500/5 transition-all outline-none text-gray-800 font-bold"
                            placeholder="e.g. Luxury Hoodies">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-8 focus:ring-indigo-500/5 transition-all outline-none text-gray-800"
                            placeholder="Describe what this category contains...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="space-y-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Category Image</label>
                        <div class="group relative flex items-center justify-center h-48 border-2 border-dashed border-gray-100 rounded-[2rem] hover:border-indigo-200 transition-all bg-gray-50/30 overflow-hidden text-center">
                            <div>
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <label for="image" class="cursor-pointer font-semibold text-indigo-600 hover:text-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="image" name="image" type="file" class="sr-only">
                                </label>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <label class="relative inline-flex items-center cursor-pointer w-full justify-between p-6 rounded-2xl bg-indigo-50/30 border border-indigo-50/50">
                            <span class="text-sm font-semibold text-gray-700">Active Status</span>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="relative w-12 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-8 peer-focus:ring-indigo-500/10 rounded-full peer peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 transition-all duration-300"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-12 pt-8 border-t border-gray-50 flex items-center justify-end gap-4">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-5 rounded-2xl shadow-xl shadow-indigo-600/20 font-bold transition-all transform hover:-translate-y-1">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
