@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Product Details</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg> Back
                </a>
                <a href="{{ route('admin.products.edit', $product->id) }}"
                    class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg> Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Product Information -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Overview</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Product Name</p>
                                <p class="text-gray-900 font-medium">{{ $product->product_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Status</p>
                                @if($product->status)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Sale Status</p>
                                @if($product->is_sale)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Sale On</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Sale Off</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Price</p>
                                <p class="text-gray-900">
                                    {{ $product->price ? '$' . number_format($product->price, 2) : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Color</p>
                                <p class="text-gray-900">{{ $product->color ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Size</p>
                                <p class="text-gray-900">{{ $product->size ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Special Effects</p>
                                <p class="text-gray-900">{{ $product->special_effects ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Washing & Dyeing Category</p>
                                <p class="text-gray-900">{{ $product->washing_dyeing_category ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Category</p>
                                <p class="text-gray-900">{{ $product->category->category_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Subcategory</p>
                                <p class="text-gray-900">{{ $product->subcategory->category_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Created At</p>
                                <p class="text-gray-900">{{ $product->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Description</h2>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none text-gray-600">
                            {!! $product->description ?? 'No description provided.' !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar / Image -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Main Image</h2>
                    </div>
                    <div class="p-6">
                        @if($product->main_image)
                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}"
                                class="w-full h-auto rounded-lg shadow-sm">
                        @else
                            <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p>No image uploaded</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($product->galleries->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Product Gallery</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($product->galleries as $gallery)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $gallery->image_path) }}"
                                            class="w-full h-24 object-cover rounded-lg border border-gray-100 shadow-sm transition-transform duration-300 group-hover:scale-105"
                                            alt="Gallery Image">
                                        <div
                                            class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 rounded-lg">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection