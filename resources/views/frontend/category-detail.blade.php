@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="container-custom">
        <!-- Breadcrumb / Header -->
        <div class="mb-8 p-4 bg-white rounded-xl shadow-sm border border-gray-50">
            <nav class="flex text-sm font-medium text-gray-500 mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">Home</a>
                    </li>
                    
                    @php
                        $path = [];
                        $curr = $category->parent;
                        while($curr) {
                            $path[] = $curr;
                            $curr = $curr->parent;
                        }
                        $path = array_reverse($path);
                    @endphp

                    @foreach($path as $p)
                        <li class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <a href="{{ route('frontend.category.detail', $p->slug) }}" class="hover:text-indigo-600 transition-colors">
                                {{ $p->category_name }}
                            </a>
                        </li>
                    @endforeach

                    <li class="flex items-center" aria-current="page">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-indigo-600 font-bold">{{ $category->category_name }}</span>
                    </li>
                </ol>
            </nav>


            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $category->category_name }}</h1>
            {{-- <p class="text-gray-600">
                @if($subcategories->count() > 0)
                    Explore our specific solutions and offerings in this category.
                @else
                    Browse our products in this category.
                @endif
            </p> --}}
        </div>

        @if($subcategories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($subcategories as $sub)
                    <!-- Added anchor tag to make entire card clickable -->
                    <a href="{{ route('frontend.category.detail', $sub->slug) }}" class="block group">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col">
                            <div class="bg-gray-100 overflow-hidden relative" style="height: 320px;"> <!-- Standardized high-end height -->
                                @if($sub->image)
                                    <img src="{{ asset('storage/' . $sub->image) }}" alt="{{ $sub->category_name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 font-black text-3xl">
                                        {{ substr($sub->category_name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-all duration-300"></div>
                            </div>
                            <div class="p-6 text-center mt-auto bg-white">
                                <h3 class="text-xl font-black text-gray-900 group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $sub->category_name }}</h3>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        @elseif(isset($products) && $products->count() > 0)
            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group flex flex-col h-full">
                        <a href="{{ route('frontend.products.detail', $product->slug) }}" class="flex flex-col h-full">
                            <div class="bg-gray-50 overflow-hidden relative flex items-center justify-center" style="height: 450px;"> <!-- Increased height for portrait fashion -->
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" style="object-position: top;">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                        <span class="font-bold uppercase tracking-widest text-xs">No Image</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/2 transition-all duration-300"></div>
                            </div>
                            <div class="p-6 flex flex-col flex-grow bg-white">
                                <h3 class="text-lg font-black text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors leading-tight">{{ $product->product_name }}</h3>
                                
                                <div class="flex items-center gap-2 mb-4">
                                    @if($product->discount_price)
                                        <span class="text-xl font-bold text-red-600">PKR {{ number_format($product->discount_price) }}</span>
                                        <span class="text-sm text-gray-400 line-through">PKR {{ number_format($product->price) }}</span>
                                    @elseif($product->price)
                                        <span class="text-xl font-bold text-gray-900">PKR {{ number_format($product->price) }}</span>
                                    @endif
                                </div>

                                <p class="text-gray-600 text-sm line-clamp-2 mb-6 flex-grow">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 80) }}
                                </p>
                                <div class="mt-auto pt-4 border-t border-gray-50">
                                    <span class="text-indigo-600 font-bold text-sm flex items-center">
                                        View Details 
                                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        @else
            <!-- No Subcategories AND No Products -->
            <div class="text-center py-20 bg-white rounded-lg shadow">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No content found</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for new additions in this category.</p>
                <div class="mt-6">
                    @if($category->parent)
                        <a href="{{ route('frontend.category.detail', $category->parent->slug) }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300">
                            Back to {{ $category->parent->category_name }}
                        </a>
                    @else
                        <a href="{{ route('frontend.categories') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300">
                            Back to Categories
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
