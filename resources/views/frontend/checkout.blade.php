@extends('frontend.layouts.app')

@push('styles')
<script src="https://js.stripe.com/v3/"></script>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container-custom">
        <h1 class="text-3xl font-black text-gray-900 mb-8 border-b pb-4">Checkout</h1>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl flex items-center gap-3 animate-fade-in">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-center gap-3 animate-fade-in">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl animate-fade-in">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    <p class="text-red-800 font-bold">Please correct the following errors:</p>
                </div>
                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="checkout-form" action="{{ route('frontend.checkout.place') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Shipping & Payment Details -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Shipping Information</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-600">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->name) }}" required
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                                @error('first_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-600">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-600">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-600">Phone Number <span class="text-red-500">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+92 000 0000000"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                                @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-bold text-gray-600">Full Address <span class="text-red-500">*</span></label>
                                <textarea name="address" rows="3" required placeholder="House#, Street, Area, etc."
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">{{ old('address') }}</textarea>
                                @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-600">City <span class="text-red-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}" required
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                                @error('city') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-600">Zip/Postal Code</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Payment Method</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Cash on Delivery -->
                            <div class="relative">
                                <input type="radio" name="payment_method" value="cod" id="payment_cod" checked class="hidden payment-option-input">
                                <label for="payment_cod" class="payment-option-card flex items-center gap-4 border-2 border-gray-100 rounded-2xl p-5 cursor-pointer hover:border-indigo-100 transition-all group relative">
                                    <div class="text-3xl text-gray-400 group-hover:text-indigo-600 transition-colors">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-800">Cash on Delivery</p>
                                        <p class="text-xs text-gray-500">Pay when you receive</p>
                                    </div>
                                    <div class="check-icon hidden text-[#f85606] text-xl">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>

                            <!-- Credit Card (Stripe) -->
                            <div class="relative">
                                <input type="radio" name="payment_method" value="stripe" id="payment_stripe" class="hidden payment-option-input">
                                <label for="payment_stripe" class="payment-option-card flex items-center gap-4 border-2 border-gray-100 rounded-2xl p-5 cursor-pointer hover:border-indigo-100 transition-all group relative">
                                    <div class="text-3xl text-gray-400 group-hover:text-indigo-600 transition-colors">
                                        <i class="fab fa-cc-stripe"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-800">Credit Card / Debit Card</p>
                                        <p class="text-xs text-gray-500">Secure online payment</p>
                                    </div>
                                    <div class="check-icon hidden text-[#f85606] text-xl">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Stripe Card Element -->
                        <div id="stripe-card-element-container" class="mt-8 hidden animate-fade-in">
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                <label class="text-sm font-bold text-gray-600 mb-4 block">Card Information</label>
                                <div class="mb-4">
                                    <input id="card-holder-name" type="text" placeholder="Card Holder Name"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-800 outline-none focus:border-[#f85606] transition-colors"
                                        required>
                                </div>
                                <div id="card-element"></div>
                                <div id="card-errors" role="alert" class="text-xs text-red-500 mt-3 font-medium"></div>
                                
                                <div class="mt-4 flex gap-3 text-3xl text-gray-400">
                                    <i class="fab fa-cc-visa hover:text-blue-600 transition-colors"></i>
                                    <i class="fab fa-cc-mastercard hover:text-red-600 transition-colors"></i>
                                    <i class="fab fa-cc-amex hover:text-blue-400 transition-colors"></i>
                                    <i class="fab fa-cc-discover hover:text-orange-500 transition-colors"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Order Notes (Optional)</h2>
                        </div>
                        <textarea name="order_notes" rows="3" placeholder="Notes about your order, e.g. special notes for delivery."
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">{{ old('order_notes') }}</textarea>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="lg:col-span-4">
                    <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white sticky top-24 shadow-2xl">
                        <h2 class="text-2xl font-black mb-8 border-b border-white/10 pb-4">Order Summary</h2>
                        
                        <!-- Mini Cart Items -->
                        <div class="space-y-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar mb-8">
                            @foreach($cartItems as $item)
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 bg-white/10 rounded-xl overflow-hidden shrink-0">
                                        @if($item->product->main_image)
                                            <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold line-clamp-1">{{ $item->product->product_name }}</h4>
                                        <p class="text-xs text-indigo-300">Qty: {{ $item->quantity }} @if($item->size) | {{ $item->size }} @endif</p>
                                        <p class="text-sm font-black mt-1">PKR {{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 border-t border-white/10 pt-6">
                            <div class="flex justify-between text-indigo-200">
                                <span>Subtotal</span>
                                <span>PKR {{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-indigo-200 text-sm">
                                <span>Shipping Fee</span>
                                <span class="text-green-400 font-bold">FREE</span>
                            </div>
                            @if(session('discount'))
                            <div class="flex justify-between text-indigo-200 text-sm">
                                <span>Discount</span>
                                <span>- PKR {{ number_format(session('discount')) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-xl font-black pt-4 border-t border-white/10 mt-4">
                                <span>Total</span>
                                <span>PKR {{ number_format($total) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-10 py-5 bg-white text-indigo-900 rounded-2xl font-black text-lg transition-all transform hover:-translate-y-1 hover:shadow-2xl flex items-center justify-center gap-3">
                            <span>Place Order Now</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>

                        <div class="mt-6 flex items-center justify-center gap-4 text-indigo-300 text-xs opacity-70">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-lock"></i>
                                <span>Secure Checkout</span>
                            </div>
                            <div class="w-1 h-1 bg-white/20 rounded-full"></div>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-shield-alt"></i>
                                <span>Buyer Protection</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stripeKey = "{{ config('services.stripe.key') }}";
        const form = document.getElementById('checkout-form');
        const cardContainer = document.getElementById('stripe-card-element-container');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const cardErrors = document.getElementById('card-errors');
        
        let stripe = null;
        let card = null;
        let isMockMode = (stripeKey === 'pk_test_your_public_key' || !stripeKey);

        const style = {
            base: {
                color: '#1f2937',
                fontFamily: '"Inter", sans-serif',
                fontSize: '16px',
                '::placeholder': { color: '#9ca3af' }
            }
        };

        if (isMockMode) {
            console.warn('Stripe Mock Mode Active: Using dummy card input.');
            const cardEl = document.getElementById('card-element');
            if (cardEl) {
                cardEl.innerHTML = `
                    <div class="relative">
                        <input type="text" placeholder="4242 4242 4242 4242 (Mock Mode)" 
                               class="w-full px-4 py-3 border rounded-xl bg-white text-gray-800 outline-none focus:border-[#f85606]">
                        <span class="absolute right-3 top-3 text-xs text-orange-500 font-bold">TEST MODE</span>
                    </div>
                `;
            }
        } else {
            try {
                stripe = Stripe(stripeKey);
                const elements = stripe.elements();
                card = elements.create('card', {style: style, hidePostalCode: true});
                card.mount('#card-element');
            } catch (e) {
                console.error('Stripe Initialization Error:', e);
                isMockMode = true;
            }
        }

        const toggleStripeElement = () => {
            const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
            if (!checkedRadio) return;
            
            const selected = checkedRadio.value;
            if (selected === 'stripe') {
                cardContainer.classList.remove('hidden');
            } else {
                cardContainer.classList.add('hidden');
            }
        };

        paymentRadios.forEach(radio => radio.addEventListener('change', toggleStripeElement));
        toggleStripeElement();

        form.addEventListener('submit', async (event) => {
            const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
            if (!checkedRadio) return;
            
            const selectedMethod = checkedRadio.value;
            
            if (selectedMethod === 'stripe') {
                event.preventDefault();
                console.log('Processing Stripe Payment in ' + (isMockMode ? 'MOCK' : 'REAL') + ' mode...');

                if (isMockMode) {
                    console.log('Submitting with Mock Token');
                    stripeTokenHandler({id: 'tok_visa'});
                } else {
                    const cardHolderName = document.getElementById('card-holder-name').value;
                    const {token, error} = await stripe.createToken(card, {
                        name: cardHolderName,
                    });

                    if (error) {
                        cardErrors.textContent = error.message;
                        console.error('Stripe Tokenization Error:', error);
                    } else {
                        stripeTokenHandler(token);
                    }
                }
            }
        });

        const stripeTokenHandler = (token) => {
            console.log('Token received, submitting form.');
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        };
    });
</script>
@endpush
