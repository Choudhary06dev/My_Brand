@extends('frontend.layouts.app')

@section('content')
<div class="container-custom py-12">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="w-full lg:w-3/4">
            @if(count($cartItems) > 0)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 font-semibold text-gray-600">Product</th>
                                <th class="p-4 font-semibold text-gray-600">Price</th>
                                <th class="p-4 font-semibold text-gray-600">Quantity</th>
                                <th class="p-4 font-semibold text-gray-600">Subtotal</th>
                                <th class="p-4 font-semibold text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($cartItems as $item)
                                <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $item->id }}">
                                    <td class="p-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                                 @if($item->product->main_image)
                                                    <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="{{ $item->product->product_name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-800">{{ $item->product->product_name }}</h3>
                                                <p class="text-sm text-gray-500">{{ Str::limit($item->product->short_description, 30) }}</p>
                                                @if($item->size || $item->color)
                                                    <div class="text-xs text-gray-400 mt-1">
                                                        @if($item->size) <span>Size: {{ $item->size }}</span> @endif
                                                        @if($item->color) <span class="ml-2">Color: {{ $item->color }}</span> @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-medium text-gray-700">PKR {{ number_format($item->product->discount_price ?? $item->product->price) }}</span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center border border-gray-300 rounded-lg w-max">
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 update-qty-btn" data-action="decrease">-</button>
                                            <input type="number" min="1" value="{{ $item->quantity }}" class="w-12 text-center border-none focus:ring-0 p-1 qty-input">
                                            <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 update-qty-btn" data-action="increase">+</button>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-bold text-indigo-600 item-subtotal">PKR {{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity) }}</span>
                                    </td>
                                    <td class="p-4">
                                        <button class="text-red-500 hover:text-red-700 transition-colors remove-item-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="text-6xl mb-4">🛒</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
                    <a href="{{ route('frontend.products') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-1/4">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 sticky top-24">
                <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">
                            PKR {{ number_format($cartItems->sum(function($item) { 
                                return ($item->product->discount_price ?? $item->product->price) * $item->quantity; 
                            })) }}
                        </span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>Calculated at checkout</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4 flex justify-between font-bold text-lg text-gray-900">
                        <span>Total</span>
                        <span id="cart-total">
                             PKR {{ number_format($cartItems->sum(function($item) { 
                                return ($item->product->discount_price ?? $item->product->price) * $item->quantity; 
                            })) }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('frontend.checkout') }}" class="block w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 text-center">
                    Proceed to Checkout
                </a>
                
                <a href="{{ route('frontend.products') }}" class="block text-center mt-4 text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Update Quantity
        $('.update-qty-btn').click(function() {
            let row = $(this).closest('tr');
            let input = row.find('.qty-input');
            let currentQty = parseInt(input.val());
            let action = $(this).data('action');
            let newQty = action === 'increase' ? currentQty + 1 : currentQty - 1;

            if (newQty < 1) return;

            input.val(newQty);
            updateCartItem(row.data('id'), newQty, row);
        });

        $('.qty-input').change(function() {
            let row = $(this).closest('tr');
            let newQty = parseInt($(this).val());
            if (newQty < 1) {
                $(this).val(1);
                newQty = 1;
            }
            updateCartItem(row.data('id'), newQty, row);
        });

        function updateCartItem(id, quantity, row) {
            $.ajax({
                url: "{{ route('frontend.cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    quantity: quantity
                },
                success: function(response) {
                    if(response.status === 'success') {
                        row.find('.item-subtotal').text('PKR ' + new Intl.NumberFormat().format(response.subtotal));
                        $('#cart-subtotal').text('PKR ' + new Intl.NumberFormat().format(response.total));
                        $('#cart-total').text('PKR ' + new Intl.NumberFormat().format(response.total));
                        // Update cart count in header if visible
                        updateCartCount(); 
                    }
                }
            });
        }

        // Remove Item
        $('.remove-item-btn').click(function() {
            if(!confirm('Are you sure you want to remove this item?')) return;

            let row = $(this).closest('tr');
            let id = row.data('id');

            $.ajax({
                url: "{{ route('frontend.cart.remove') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if(response.status === 'success') {
                        row.fadeOut(300, function() { $(this).remove(); });
                        $('#cart-subtotal').text('PKR ' + new Intl.NumberFormat().format(response.total));
                        $('#cart-total').text('PKR ' + new Intl.NumberFormat().format(response.total));
                        updateCartCount();
                        
                        if(response.cart_count === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }
                }
            });
        });

        function updateCartCount() {
            $.get("{{ route('frontend.cart.count') }}", function(data) {
                $('.cart-count-badge').text(data.count);
                if(data.count > 0) {
                     $('.cart-count-badge').show();
                } else {
                     $('.cart-count-badge').hide();
                }
            });
        }
    });
</script>
@endsection
