@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold text-gray-800">Order Details #{{ $order->order_number }}</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-3 bg-white p-2 rounded-xl border border-gray-100 shadow-sm">
                    @csrf
                    @method('PATCH')
                    <div>
                        <select name="status" class="text-sm rounded-lg border-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div>
                        <select name="payment_status" class="text-sm rounded-lg border-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Payment Pending</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition duration-300">
                        Update
                    </button>
                </form>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800">Order Items</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left order-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100">
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4 text-center">Price</th>
                                    <th class="px-6 py-4 text-center">Qty</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-lg bg-gray-50 flex-shrink-0">
                                                    @if($item->product && $item->product->main_image)
                                                        <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="" class="w-full h-full object-cover rounded-lg">
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-800">{{ $item->product->product_name ?? 'Product Deleted' }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        @if($item->size) Size: {{ $item->size }} @endif
                                                        @if($item->color) | Color: {{ $item->color }} @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-gray-600">Rs. {{ number_format($item->price, 2) }}</td>
                                        <td class="px-6 py-4 text-center text-gray-600">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-gray-800">Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold text-gray-800">
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right">Subtotal</td>
                                    <td class="px-6 py-3 text-right">Rs. {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right">Shipping</td>
                                    <td class="px-6 py-3 text-right">Rs. {{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr class="text-indigo-600 text-lg border-t border-gray-200">
                                    <td colspan="3" class="px-6 py-4 text-right uppercase">Grand Total</td>
                                    <td class="px-6 py-4 text-right italic">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if($order->order_notes)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-500 uppercase mb-3">Order Notes</h3>
                        <div class="text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-100 italic whitespace-pre-wrap">{{ $order->order_notes }}</div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Customer Info -->
            <div class="space-y-6">
                <!-- Customer Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-4 border-b border-gray-50 pb-2">Customer Info</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Full Name</p>
                                <p class="text-gray-800 font-bold">{{ $order->first_name }} {{ $order->last_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Email Address</p>
                                <p class="text-gray-800 font-bold truncate">{{ $order->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Phone Number</p>
                                <p class="text-gray-800 font-bold">{{ $order->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-4 border-b border-gray-50 pb-2">Shipping Address</h3>
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="text-gray-800">
                            <p class="font-bold mb-1">{{ $order->address }}</p>
                            <p>{{ $order->city }} @if($order->state), {{ $order->state }} @endif</p>
                            @if($order->zip_code)<p>Zip: {{ $order->zip_code }}</p>@endif
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-indigo-600 rounded-xl shadow-lg p-6 text-white">
                    <h3 class="text-sm font-bold text-indigo-200 uppercase mb-4 border-b border-indigo-500 pb-2">Payment Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-100 text-sm italic">Method</span>
                            <span class="font-bold uppercase tracking-widest">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-100 text-sm italic">Status</span>
                            <span class="px-2 py-0.5 rounded text-xs font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-green-400 text-green-900 border border-green-300 shadow-sm' : 'bg-yellow-400 text-yellow-900 border border-yellow-300 shadow-sm' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-indigo-500 flex justify-between items-center">
                            <span class="text-indigo-100 font-bold uppercase tracking-widest">Total Paid</span>
                            <span class="text-2xl font-black italic">Rs. {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
