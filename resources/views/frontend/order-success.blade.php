@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen flex items-center justify-center py-20 px-4">
    <div class="max-w-2xl w-full bg-white rounded-[3rem] shadow-2xl p-10 md:p-16 border border-gray-100 text-center relative overflow-hidden">
        <!-- Decoration Gradients -->
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50"></div>

        <div class="relative z-10">
            <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-10 animate-bounce shadow-lg shadow-green-100/50">
                <i class="fas fa-check"></i>
            </div>
            
            <h1 class="text-4xl font-black text-gray-900 mb-4">Order Placed Successfully!</h1>
            <p class="text-gray-500 text-lg mb-10 px-4">
                Thank you for your purchase. We have received your order and are processing it now. A confirmation email has been sent to <span class="text-indigo-600 font-bold">{{ $order->email }}</span>.
            </p>

            <div class="bg-gray-50 rounded-3xl p-8 mb-10 text-left border border-gray-100">
                <div class="grid grid-cols-2 gap-y-6">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Order Number</p>
                        <p class="text-xl font-black text-indigo-900">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Date</p>
                        <p class="text-lg font-bold text-gray-800">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Amount</p>
                        <p class="text-lg font-bold text-gray-800">PKR {{ number_format($order->total_amount) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Payment Method</p>
                        <p class="text-lg font-bold text-gray-800 uppercase">{{ $order->payment_method }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <a href="{{ route('home') }}" class="flex-1 py-5 bg-indigo-900 text-white rounded-2xl font-black text-lg shadow-xl shadow-indigo-200 hover:scale-[1.02] transition-all">
                    Back to Home
                </a>
                <a href="{{ route('frontend.products') }}" class="flex-1 py-5 bg-white text-indigo-900 border-2 border-indigo-900 rounded-2xl font-black text-lg hover:bg-gray-50 transition-all">
                    Keep Shopping
                </a>
            </div>
            
            <p class="text-gray-400 text-xs mt-10">
                Need help? <a href="{{ route('frontend.contact') }}" class="text-indigo-600 underline">Contact our support team</a>
            </p>
        </div>
    </div>
</div>
@endsection
