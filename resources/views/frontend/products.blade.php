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
                            @if($product->discount_price)
                                <div class="sale-badge">Sale</div>
                            @endif

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
                                <button class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition-colors mt-4 add-to-cart-btn" data-product-id="{{ $product->id }}">
                                    Add to Cart
                                </button>
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

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.add-to-cart-btn').click(function(e) {
                e.preventDefault();
                let btn = $(this);
                let productId = btn.data('product-id');
                
                btn.prop('disabled', true).text('Adding...');
                
                $.ajax({
                    url: "{{ route('frontend.cart.add') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: 1
                    },
                    success: function(response) {
                        if(response.status === 'success') {
                            btn.text('Added!').addClass('bg-green-600 hover:bg-green-700').removeClass('bg-indigo-600 hover:bg-indigo-700');
                            setTimeout(function() {
                                btn.prop('disabled', false).text('Add to Cart').removeClass('bg-green-600 hover:bg-green-700').addClass('bg-indigo-600 hover:bg-indigo-700');
                            }, 2000);
                            
                            // Update cart count if function exists
                            if (typeof updateCartCount === 'function') {
                                updateCartCount();
                            } else {
                                // Fallback if function not available yet (e.g. cached header)
                                try {
                                    const badge = document.querySelector('.cart-count-badge');
                                    if(badge) {
                                        let count = parseInt(badge.innerText) || 0;
                                        badge.innerText = count + 1;
                                        badge.style.display = 'flex';
                                    }
                                } catch(e) {}
                            }
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Add to Cart');
                        if (xhr.status === 401) {
                            window.location.href = "{{ route('frontend.login') }}";
                        } else {
                            alert('Failed to add to cart. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
    @endpush
@endsection