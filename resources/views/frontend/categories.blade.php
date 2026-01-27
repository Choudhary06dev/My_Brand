@extends('frontend.layouts.app')

@section('content')

<div class="bg-gray-50 py-12" style="margin-top: 70px;">
    <div class="container-custom">
        <div class="section-header">
            <h2 class="section-title">All Categories</h2>
            <p class="section-subtitle">Explore our wide range of products across all categories</p>
        </div>

        @if(isset($categories) && $categories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($categories as $category)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full transform hover:-translate-y-1">
                        <a href="{{ route('frontend.category.detail', $category->slug) }}" class="flex flex-col h-full">
                            <div class="relative h-64 overflow-hidden bg-gray-100">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="{{ $category->category_name }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-4xl font-bold bg-gray-50 uppercase">
                                        {{ substr($category->category_name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="p-6 text-center flex-grow flex flex-col justify-center">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition-colors">
                                    {{ strtoupper($category->category_name) }}
                                </h3>
                                <span class="inline-block mt-3 text-indigo-600 font-semibold text-sm hover:underline">
                                    View Products →
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-1.414 0H9.172a1 1 0 01-1.414 0l-2.414-2.414a1 1 0 00-.707-.293H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No categories found</h3>
                <p class="text-gray-500 mt-1">Check back later for updates.</p>
            </div>
        @endif
    </div>
</div>

@endsection
