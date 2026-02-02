@extends('frontend.layouts.app')

@section('content')
    <section class="products-container">
        <div class="container-custom">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                            Home
                        </a>
                    </li>
                    @if(isset($category))
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('frontend.sale') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 md:ml-2">Sale</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $category->category_name }}</span>
                        </div>
                    </li>
                    @else
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Sale</span>
                        </div>
                    </li>
                    @endif
                </ol>
            </nav>

            <div class="section-header">
                <h2 class="section-title">
                    @if(isset($category))
                        Sale: {{ $category->category_name }}
                    @else
                        Products on Sale
                    @endif
                </h2>
                <p class="section-subtitle">Grab your favorites before they're gone!</p>
            </div>

            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
                        <div class="product-card">
                            <div class="sale-badge">Sale</div>
                            
                            @if($product->category)
                                <div class="category-hover-label">
                                    @if($product->childSubcategory)
                                        {{ $product->childSubcategory->category_name }}
                                    @elseif($product->subcategory)
                                        {{ $product->subcategory->category_name }}
                                    @else
                                        {{ $product->category->category_name }}
                                    @endif
                                </div>
                            @endif

                            <div class="product-image">
                                <a href="{{ route('frontend.products.detail', $product->slug) }}" class="block w-full h-full">
                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}">
                                    @else
                                        <div class="image-placeholder">
                                            <span>📦</span>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title">{{ $product->product_name }}</h3>
                                <div class="flex items-center gap-2 mb-3">
                                    @if($product->discount_price)
                                        <span class="text-lg font-bold text-red-600">PKR
                                            {{ number_format($product->discount_price) }}</span>
                                        <span class="text-sm text-gray-400 line-through">PKR {{ number_format($product->price) }}</span>
                                    @elseif($product->price)
                                        <span class="text-lg font-bold text-gray-900">PKR {{ number_format($product->price) }}</span>
                                    @endif
                                </div>
                                <p class="product-description">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 120) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-gray-500 text-lg">No sale products found in this category.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
