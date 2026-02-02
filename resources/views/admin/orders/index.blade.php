@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Orders</h1>
            <a href="{{ route('admin.orders.summary-page') }}" 
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Order Summary
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold">
                            <th class="px-6 py-4">Order #</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 font-mono text-sm text-indigo-600 font-bold">
                                    <a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-bold">
                                    Rs. {{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-xs font-semibold uppercase text-gray-500">{{ strtoupper($order->payment_method) }}</span>
                                        @if($order->payment_status === 'paid')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 w-fit">Paid</span>
                                        @elseif($order->payment_status === 'failed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 w-fit">Failed</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 w-fit">Pending</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-green-100 text-green-800',
                                            'out_for_delivery' => 'bg-indigo-100 text-indigo-800',
                                            'completed' => 'bg-emerald-100 text-emerald-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'refunded' => 'bg-purple-100 text-purple-800',
                                        ];
                                        $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                            title="Order Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this order?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                                title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <p class="text-lg font-medium">No orders found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Order Summary Modal -->
    <div id="summaryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                
                <!-- Modal Header -->
                <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white" id="modal-title">Order Summary & Profit Analysis</h3>
                    <button type="button" class="text-indigo-100 hover:text-white focus:outline-none" onclick="closeSummaryModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Filter Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex gap-2 flex-wrap">
                        <button onclick="loadSummary('weekly')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-white border border-gray-300 text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700">
                            Weekly
                        </button>
                        <button onclick="loadSummary('monthly')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-white border border-gray-300 text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700">
                            Monthly
                        </button>
                        <button onclick="loadSummary('yearly')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-white border border-gray-300 text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700">
                            Yearly
                        </button>
                        <button onclick="loadSummary('all')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-indigo-600 border border-indigo-600 text-white">
                            All Time
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <div id="summaryContent" class="space-y-4">
                        <!-- Loading State -->
                        <div class="flex justify-center py-8">
                            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openSummaryModal() {
            const modal = document.getElementById('summaryModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            loadSummary('all'); // Load all time by default
        }

        function closeSummaryModal() {
            const modal = document.getElementById('summaryModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function loadSummary(filter) {
            const content = document.getElementById('summaryContent');
            
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'border-indigo-600', 'text-white');
                btn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
            });
            event.target.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
            event.target.classList.add('bg-indigo-600', 'border-indigo-600', 'text-white');

            // Show loading
            content.innerHTML = `
                <div class="flex justify-center py-8">
                    <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            `;

            // Fetch summary data
            fetch(`{{ route('admin.orders.summary') }}?filter=${filter}`)
                .then(response => response.json())
                .then(data => {
                    const filterLabels = {
                        'weekly': 'This Week',
                        'monthly': 'This Month',
                        'yearly': 'This Year',
                        'all': 'All Time'
                    };

                    content.innerHTML = `
                        <div class="text-center mb-6">
                            <p class="text-sm text-gray-500 uppercase tracking-wide font-semibold">${filterLabels[data.filter]}</p>
                            <p class="text-xs text-gray-400 mt-1">${data.order_count} Completed Orders</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Total Purchase Cost -->
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-red-600 uppercase tracking-wide">Total Purchase Cost</p>
                                        <p class="text-2xl font-bold text-red-700 mt-1">Rs. ${data.total_purchase_cost}</p>
                                    </div>
                                    <div class="bg-red-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Sales -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-blue-600 uppercase tracking-wide">Total Sales</p>
                                        <p class="text-2xl font-bold text-blue-700 mt-1">Rs. ${data.total_sales}</p>
                                    </div>
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Profit -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-green-600 uppercase tracking-wide">Total Profit</p>
                                        <p class="text-2xl font-bold text-green-700 mt-1">Rs. ${data.total_profit}</p>
                                    </div>
                                    <div class="bg-green-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Profit Margin -->
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-purple-600 uppercase tracking-wide">Profit Margin</p>
                                        <p class="text-2xl font-bold text-purple-700 mt-1">${data.profit_margin}%</p>
                                    </div>
                                    <div class="bg-purple-100 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Breakdown -->
                        ${data.products && data.products.length > 0 ? `
                            <div class="mt-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Product Breakdown</h4>
                                <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                                    <div class="overflow-x-auto max-h-96">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 border-b border-gray-200 sticky top-0">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Qty</th>
                                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Cost</th>
                                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Sales</th>
                                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                ${data.products.map(product => `
                                                    <tr class="hover:bg-gray-100 transition-colors">
                                                        <td class="px-4 py-3 text-gray-800 font-medium">${product.name}</td>
                                                        <td class="px-4 py-3 text-center">
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                                                ${product.quantity}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-3 text-right text-red-600 font-medium">Rs. ${product.total_cost}</td>
                                                        <td class="px-4 py-3 text-right text-blue-600 font-medium">Rs. ${product.total_sale}</td>
                                                        <td class="px-4 py-3 text-right text-green-600 font-bold">Rs. ${product.total_profit}</td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        ` : ''}
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = '<p class="text-red-500 text-center py-4">Error loading summary data.</p>';
                });
        }

        // Close modal on backdrop click
        document.getElementById('summaryModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeSummaryModal();
            }
        });
    </script>
@endsection
