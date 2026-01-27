@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Edit Page</h1>

            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug <span
                                    class="text-xs text-gray-500">(auto-generated if empty)</span></label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <textarea name="content" id="content" rows="10"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">Banner
                                Image</label>
                            @if($page->banner_image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $page->banner_image) }}" alt="Current Banner"
                                        class="w-full max-w-md h-32 object-cover rounded border border-gray-200">
                                    <p class="mt-1 text-xs text-gray-500">Current banner (will be replaced if you upload a new
                                        one)
                                    </p>
                                </div>
                            @endif
                            <input type="file" name="banner_image" id="banner_image"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('banner_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">SEO Settings</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-2">SEO
                                        Title</label>
                                    <input type="text" name="seo_title" id="seo_title"
                                        value="{{ old('seo_title', $page->seo_title) }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    @error('seo_title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-2">SEO
                                        Description</label>
                                    <textarea name="seo_description" id="seo_description" rows="3"
                                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('seo_description', $page->seo_description) }}</textarea>
                                    @error('seo_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 border-t border-gray-100 pt-6">
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 shadow-sm">
                            Update Page
                        </button>
                        <a href="{{ route('admin.pages.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200"
                            style="margin-left: 0.5rem;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('content');
            }
        </script>
    @endpush
@endsection