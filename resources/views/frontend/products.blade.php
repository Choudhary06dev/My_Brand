@extends('frontend.layouts.app')

@section('content')
    <style>
        .products-container {
            padding: 4rem 0;
            background: #f9fafb;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            width: 100%;
            height: 450px;
            background: #fdfdfd;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid #f3f4f6;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .product-content {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #111827;
        }

        .product-description {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        /* Category Hover Label */
        .category-hover-label {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(var(--accent-1-rgb, 124, 58, 237), 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 99px;
            font-size: 0.875rem;
            font-weight: 600;
            transform: translateY(-10px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 10;
            backdrop-filter: blur(4px);
        }

        .product-card:hover .category-hover-label {
            transform: translateY(0);
            opacity: 1;
        }
    </style>

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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Products</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="section-header">
                <h2 class="section-title">Our Products</h2>
                <p class="section-subtitle">Discover our wide range of high-quality products</p>
            </div>

            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
                        <div class="product-card">
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
                    <p class="text-gray-500 text-lg">No products found.</p>
                </div>
            @endif
        </div>
    </section>
@endsection