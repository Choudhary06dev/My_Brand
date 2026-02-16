@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="container-custom">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                            Home
                        </a>
                    </li>

                    @php
                        // Find the deepest available category level
                        $leaf = $product->childSubcategory ?: ($product->subcategory ?: $product->category);
                        $path = [];
                        $curr = $leaf;
                        while ($curr) {
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
                            <a href="{{ route('frontend.category.detail', $p->slug) }}"
                                class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                                {{ $p->category_name }}
                            </a>
                        </li>
                    @endforeach

                    <li class="flex items-center" aria-current="page">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-gray-500 truncate max-w-[150px] md:max-w-xs">
                            {{ $product->product_name }}
                        </span>
                    </li>
                </ol>
            </nav>


            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Left: Product Images -->
                    <div class="bg-gray-50 flex gap-4 p-4 lg:p-6" style="min-height: 550px; height: 550px;">
                        <!-- Thumbnails (Vertical) -->
                        @php
                            $allImages = [];
                            if ($product->main_image) {
                                $allImages[] = ['path' => 'storage/' . $product->main_image, 'is_main' => true, 'caption' => 'Main Image'];
                            }
                            foreach ($product->galleries as $gallery) {
                                $allImages[] = ['path' => 'storage/' . $gallery->image_path, 'is_main' => false, 'caption' => $gallery->caption];
                            }
                        @endphp

                        @if(count($allImages) > 1)
                            <div class="hidden lg:flex flex-col gap-3 overflow-y-auto pr-1">
                                @foreach($allImages as $index => $image)
                                    <div class="thumbnail-item w-20 h-24 flex-shrink-0 rounded-lg overflow-hidden cursor-pointer border-2 transition-all duration-300 {{ $index === 0 ? 'border-indigo-600 shadow-sm' : 'border-gray-200 hover:border-indigo-400' }}"
                                        onmouseenter="changeMainImage('{{ asset($image['path']) }}', this)"
                                        onmouseleave="resetMainImage()"
                                        onclick="changeMainImage('{{ asset($image['path']) }}', this, true)">
                                        <img src="{{ asset($image['path']) }}" class="w-full h-full object-cover object-top">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Main Image Area -->
                        <div
                            class="flex-1 relative overflow-hidden rounded-2xl bg-white shadow-inner border border-gray-100">
                            @if($product->main_image || $product->galleries->count() > 0)
                                @php
                                    $displayImage = $product->main_image ? 'storage/' . $product->main_image : 'storage/' . $product->galleries->first()->image_path;
                                @endphp
                                <img id="mainProductImage" src="{{ asset($displayImage) }}" alt="{{ $product->product_name }}"
                                    class="absolute inset-0 w-full h-full object-contain p-4 transition-all duration-500 transform hover:scale-125 cursor-zoom-in">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Product Details -->
                    <div class="p-4 lg:px-12 lg:pt-6 pb-10">
                        <div class="mb-2">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-widest">
                                @if($product->childSubcategory)
                                    {{ $product->childSubcategory->category_name }}
                                @elseif($product->subcategory)
                                    {{ $product->subcategory->category_name }}
                                @elseif($product->category)
                                    {{ $product->category->category_name }}
                                @else
                                    Ready To Wear
                                @endif
                            </span>
                        </div>

                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 leading-tight">
                            {{ $product->product_name }}
                        </h1>

                        @if($product->price)
                            <div class="flex items-baseline gap-2 mb-6">
                                @if($product->discount_price)
                                    <span class="text-2xl font-bold text-red-600">PKR
                                        {{ number_format($product->discount_price) }}</span>
                                    <span class="text-lg text-gray-400 line-through">PKR {{ number_format($product->price) }}</span>
                                @else
                                    <span class="text-2xl font-bold text-gray-900">PKR {{ number_format($product->price) }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="text-sm text-gray-600 mb-8 pb-6 border-b border-gray-100 flex flex-col gap-2">
                            <div>
                                <span class="font-medium">Item:</span>
                                {{ $product->product_type ?? '1 Piece' }}
                            </div>
                            @if($product->fabricCategory || $product->fabric)
                                <div>
                                    <span class="font-medium">Fabric:</span>
                                    {{ $product->fabricCategory->name ?? '' }}
                                    {{ $product->fabric->name ? '+ ' . $product->fabric->name : '' }}
                                </div>
                            @endif
                        </div>

                        <!-- Size Selection -->
                        @if($product->size)
                            <div class="mb-8">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-sm font-bold text-gray-900 uppercase">Size</span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $sizes = explode(',', $product->size);
                                    @endphp
                                    @foreach($sizes as $size)
                                        <button type="button"
                                            class="size-box min-w-[50px] h-11 px-3 flex items-center justify-center border border-gray-300 text-sm font-bold transition-all duration-200 hover:border-gray-900"
                                            onclick="selectSize(this, '{{ trim($size) }}')">
                                            {{ trim($size) }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Color Selection -->
                        @if($product->color)
                            <div class="mb-8">
                                <span class="block text-sm font-bold text-gray-900 uppercase mb-4">Color:
                                    <span id="selectedColorName">{{ trim(explode(',', $product->color)[0]) }}</span></span>
                                <div class="flex flex-wrap gap-3">
                                    @php
                                        $colors = explode(',', $product->color);
                                    @endphp
                                    @foreach($colors as $index => $color)
                                        @php
                                            $trimmedColor = trim($color);
                                            // Handle special color names or hex codes if needed
                                            $displayColor = strtolower($trimmedColor);
                                            // Comprehensive color mapping for common fashion/design colors
                                            $colorMap = [
                                                // Standard Colors
                                                'white' => '#ffffff',
                                                'black' => '#000000',
                                                'red' => '#ef4444',
                                                'blue' => '#3b82f6',
                                                'green' => '#22c55e',
                                                'pink' => '#ec4899',
                                                'yellow' => '#eab308',
                                                'gray' => '#6b7280',
                                                'grey' => '#6b7280',
                                                'orange' => '#f97316',
                                                'purple' => '#a855f7',
                                                'indigo' => '#6366f1',
                                                'violet' => '#8b5cf6',
                                                
                                                // Fashion & Common Tones
                                                'navy' => '#1e3a8a',
                                                'navy blue' => '#1e3a8a',
                                                'maroon' => '#800000',
                                                'burgundy' => '#800020',
                                                'crimson' => '#dc143c',
                                                'teal' => '#0d9488',
                                                'cyan' => '#06b6d4',
                                                'turquoise' => '#40e0d0',
                                                'magenta' => '#d946ef',
                                                'lavender' => '#e6e6fa',
                                                'beige' => '#f5f5dc',
                                                'cream' => '#fffdd0',
                                                'ivory' => '#fffff0',
                                                'khaki' => '#f0e68c',
                                                'olive' => '#808000',
                                                'brown' => '#92400e',
                                                'chocolate' => '#d2691e',
                                                'tan' => '#d2b48c',
                                                'coffee' => '#6f4e37',
                                                'mustard' => '#ffdb58',
                                                'gold' => '#ffd700',
                                                'silver' => '#c0c0c0',
                                                'charcoal' => '#36454f',
                                                'slate' => '#708090',
                                                'sky blue' => '#87ceeb',
                                                'baby blue' => '#89cff0',
                                                'baby pink' => '#f4c2c2',
                                                'peach' => '#ffdab9',
                                                'coral' => '#ff7f50',
                                                'salmon' => '#fa8072',
                                                'mint' => '#98ff98',
                                                'lime' => '#84cc16',
                                                'forest green' => '#228b22',
                                                'rust' => '#b7410e',
                                                'camel' => '#c19a6b',
                                                'off white' => '#f8f8ff',
                                                'zinc' => '#71717a',
                                            ];
                                            $hexColor = $colorMap[$displayColor] ?? $displayColor;
                                        @endphp
                                        <button type="button"
                                            class="color-swatch w-10 h-10 rounded-full border-2 transition-all duration-200 p-0.5 {{ $index === 0 ? 'border-gray-900 ring-2 ring-gray-900 ring-offset-2' : 'border-gray-200 hover:border-gray-400' }}"
                                            style="background-color: {{ $hexColor }};"
                                            onclick="selectColor(this, '{{ $trimmedColor }}')"
                                            title="{{ $trimmedColor }}">
                                            <span class="sr-only">{{ $trimmedColor }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quantity and Call to Action -->
                        <!-- Quantity and Call to Action -->
                        <div class="flex flex-col sm:flex-row gap-4 mb-8">
                            <div class="flex items-center border border-gray-300 h-14 bg-white">
                                <button type="button" onclick="decrementQty()"
                                    class="w-12 h-full flex items-center justify-center text-xl hover:bg-gray-50 transition-colors">−</button>
                                <input type="number" id="quantity" value="1" min="1"
                                    class="w-14 h-full text-center border-none focus:ring-0 font-bold text-lg bg-transparent"
                                    readonly>
                                <button type="button" onclick="incrementQty()"
                                    class="w-12 h-full flex items-center justify-center text-xl hover:bg-gray-50 transition-colors">+</button>
                            </div>

                            <!-- Add to Cart -->
                            <button type="button" id="addToCartBtn"
                                class="flex-1 bg-black text-white h-14 text-sm font-bold uppercase tracking-widest hover:bg-gray-900 transition-all duration-300 shadow-lg hover:shadow-xl transform active:scale-[0.98]"
                                onclick="addToCart()">
                                Add to Cart
                            </button>
                        </div>

                        <!-- Technical Details Accordion (Optional but good) -->
                        <div class="space-y-4 pt-4 border-t border-gray-100">
                            <div class="text-sm text-gray-600 leading-relaxed description-content">
                                {!! $product->description !!}
                            </div>
                        </div>


                        <script>
                            let selectedSize = '';
                            let selectedColor = '{{ $product->color ? trim(explode(',', $product->color)[0]) : "" }}';

                            function selectSize(btn, size) {
                                document.querySelectorAll('.size-box').forEach(b => b.classList.remove('active'));
                                btn.classList.add('active');
                                selectedSize = size;
                            }

                            function selectColor(btn, color) {
                                document.querySelectorAll('.color-swatch').forEach(b => {
                                    b.classList.remove('border-gray-900', 'ring-2', 'ring-gray-900', 'ring-offset-2');
                                    b.classList.add('border-gray-200');
                                });
                                btn.classList.remove('border-gray-200');
                                btn.classList.add('border-gray-900', 'ring-2', 'ring-gray-900', 'ring-offset-2');
                                selectedColor = color;
                                document.getElementById('selectedColorName').innerText = color;
                            }

                            function incrementQty() {
                                const input = document.getElementById('quantity');
                                input.value = parseInt(input.value) + 1;
                            }

                            function decrementQty() {
                                const input = document.getElementById('quantity');
                                if (input.value > 1) {
                                    input.value = parseInt(input.value) - 1;
                                }
                            }

                            function addToCart() {
                                // Check if size is selected (only if sizes exist)
                                const hasSizes = {{ $product->size ? 'true' : 'false' }};
                                if (hasSizes && !selectedSize) {
                                    alert('Please select a size');
                                    return;
                                }

                                const quantity = document.getElementById('quantity').value;
                                const btn = document.getElementById('addToCartBtn');
                                const originalText = btn.innerText;

                                btn.disabled = true;
                                btn.innerText = 'Adding...';

                                $.ajax({
                                    url: "{{ route('frontend.cart.add') }}",
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        product_id: {{ $product->id }},
                                        quantity: quantity,
                                        size: selectedSize,
                                        color: selectedColor
                                    },
                                    success: function(response) {
                                        if(response.status === 'success') {
                                            btn.innerText = 'Added to Cart!';
                                            btn.classList.add('bg-green-600', 'hover:bg-green-700');
                                            btn.classList.remove('bg-black', 'hover:bg-gray-900');
                                            
                                            setTimeout(function() {
                                                btn.disabled = false;
                                                btn.innerText = originalText;
                                                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                                                btn.classList.add('bg-black', 'hover:bg-gray-900');
                                            }, 2000);

                                            // Update cart count
                                            if (typeof updateCartCount === 'function') {
                                                updateCartCount();
                                            }
                                        }
                                    },
                                    error: function(xhr) {
                                        btn.disabled = false;
                                        btn.innerText = originalText;
                                        if (xhr.status === 401) {
                                            window.location.href = "{{ route('frontend.login') }}";
                                        } else {
                                            alert('Failed to add to cart. Please try again.');
                                        }
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>

            <script>
                let currentActiveImage = '{{ asset($displayImage) }}';

                function changeMainImage(imageSrc, clickedThumbnail, isClick = false) {
                    // Update main image
                    document.getElementById('mainProductImage').src = imageSrc;

                    if (isClick) {
                        currentActiveImage = imageSrc;
                        // Remove active state from all thumbnails
                        document.querySelectorAll('.thumbnail-item').forEach(thumb => {
                            thumb.classList.remove('border-indigo-600');
                            thumb.classList.add('border-gray-200', 'hover:border-indigo-400');
                        });

                        // Add active state to clicked thumbnail
                        clickedThumbnail.classList.remove('border-gray-200', 'hover:border-indigo-400');
                        clickedThumbnail.classList.add('border-indigo-600');
                    }
                }

                function resetMainImage() {
                    document.getElementById('mainProductImage').src = currentActiveImage;
                }
            </script>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <div
                                class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group flex flex-col">
                                <div class="aspect-[3/4] h-80 bg-gray-200 overflow-hidden relative">
                                    @if($related->main_image)
                                        <img src="{{ asset('storage/' . $related->main_image) }}" alt="{{ $related->product_name }}"
                                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                            <span class="text-xs font-bold uppercase tracking-widest">No Image</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-all duration-300">
                                    </div>
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <h3
                                        class="text-[17px] font-extrabold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-tight">
                                        {{ $related->product_name }}
                                    </h3>
                                    <div class="mt-auto pt-4">
                                        <a href="{{ route('frontend.products.detail', $related->slug) }}"
                                            class="inline-flex items-center text-indigo-600 font-bold text-sm group/link">
                                            <span class="mr-2">View Details</span>
                                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection