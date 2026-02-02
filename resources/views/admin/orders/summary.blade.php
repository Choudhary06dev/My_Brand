@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order Summary & Profit Analysis</h1>
                <p class="text-gray-600 mt-2">Track your sales performance and profitability</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" 
                class="px-6 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 transition duration-300 flex items-center gap-2 shadow-sm border border-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Orders
            </a>
        </div>

        <!-- Filter Buttons -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <div class="flex gap-3 flex-wrap">
                <button onclick="loadSummary('weekly', event)" class="filter-btn px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 bg-gray-100 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 hover:shadow-md transform hover:-translate-y-0.5">
                    📅 Weekly
                </button>
                <button onclick="loadSummary('monthly', event)" class="filter-btn px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 bg-gray-100 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 hover:shadow-md transform hover:-translate-y-0.5">
                    📆 Monthly
                </button>
                <button onclick="loadSummary('yearly', event)" class="filter-btn px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 bg-gray-100 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 hover:shadow-md transform hover:-translate-y-0.5">
                    📊 Yearly
                </button>
                <button onclick="loadSummary('all', event)" class="filter-btn px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg transform hover:-translate-y-0.5">
                    🌐 All Time
                </button>
            </div>
        </div>

        <!-- Summary Content -->
        <div id="summaryContent">
            <!-- Loading State -->
            <div class="flex justify-center py-20">
                <div class="text-center">
                    <svg class="animate-spin h-16 w-16 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-600 mt-4 font-medium">Loading summary...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load summary on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadSummary('all');
        });

        function loadSummary(filter, event = null) {
            const content = document.getElementById('summaryContent');
            
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-lg');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            
            // Only update the clicked button if event exists
            if (event && event.target) {
                event.target.classList.remove('bg-gray-100', 'text-gray-700');
                event.target.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-lg');
            } else {
                // If no event (page load), activate the corresponding filter button
                const filterButtons = {
                    'weekly': 0,
                    'monthly': 1,
                    'yearly': 2,
                    'all': 3
                };
                const buttons = document.querySelectorAll('.filter-btn');
                if (buttons[filterButtons[filter]]) {
                    buttons[filterButtons[filter]].classList.remove('bg-gray-100', 'text-gray-700');
                    buttons[filterButtons[filter]].classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-lg');
                }
            }

            // Show loading
            content.innerHTML = `
                <div class="flex justify-center py-20">
                    <div class="text-center">
                        <svg class="animate-spin h-16 w-16 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 mt-4 font-medium">Loading summary...</p>
                    </div>
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
                        <!-- Period Info -->
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
                            <div class="text-center">
                                <p class="text-2xl font-bold uppercase tracking-wide">${filterLabels[data.filter]}</p>
                                <p class="text-indigo-100 mt-2 text-lg">${data.order_count} Completed Orders</p>
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <!-- Total Purchase Cost -->
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-1">
                                <div class="bg-gradient-to-br from-red-500 to-pink-600 p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-white text-opacity-90 text-xs uppercase tracking-wider font-bold mb-2">Total Purchase Cost</p>
                                    <p class="text-white text-3xl font-extrabold">Rs. ${data.total_purchase_cost}</p>
                                </div>
                            </div>

                            <!-- Total Sales -->
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-1">
                                <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-white text-opacity-90 text-xs uppercase tracking-wider font-bold mb-2">Total Sales</p>
                                    <p class="text-white text-3xl font-extrabold">Rs. ${data.total_sales}</p>
                                </div>
                            </div>

                            <!-- Total Profit -->
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-1">
                                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-white text-opacity-90 text-xs uppercase tracking-wider font-bold mb-2">Total Profit</p>
                                    <p class="text-white text-3xl font-extrabold">Rs. ${data.total_profit}</p>
                                </div>
                            </div>

                            <!-- Profit Margin -->
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-1">
                                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="bg-white bg-opacity-30 p-4 rounded-xl backdrop-blur-sm">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-white text-opacity-90 text-xs uppercase tracking-wider font-bold mb-2">Profit Margin</p>
                                    <p class="text-white text-3xl font-extrabold">${data.profit_margin}%</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Breakdown -->
                        ${data.products && data.products.length > 0 ? `
                            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                                <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                    <h2 class="text-2xl font-bold text-gray-900">📦 Product Breakdown</h2>
                                    <p class="text-gray-600 mt-1">Detailed sales and profit analysis by product</p>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50">
                                            <tr>
                                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Product Name</th>
                                                <th class="px-8 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity</th>
                                                <th class="px-8 py-5 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Cost</th>
                                                <th class="px-8 py-5 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Sales</th>
                                                <th class="px-8 py-5 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            ${data.products.map((product, index) => `
                                                <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200">
                                                    <td class="px-8 py-5">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                                                                <span class="text-white font-bold">${index + 1}</span>
                                                            </div>
                                                            <div class="ml-4">
                                                                <p class="text-sm font-bold text-gray-900">${product.name}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-8 py-5 text-center">
                                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 shadow-sm">
                                                            ${product.quantity}
                                                        </span>
                                                    </td>
                                                    <td class="px-8 py-5 text-right">
                                                        <span class="text-sm font-bold text-red-600">Rs. ${product.total_cost}</span>
                                                    </td>
                                                    <td class="px-8 py-5 text-right">
                                                        <span class="text-sm font-bold text-blue-600">Rs. ${product.total_sale}</span>
                                                    </td>
                                                    <td class="px-8 py-5 text-right">
                                                        <span class="text-sm font-extrabold text-green-600">Rs. ${product.total_profit}</span>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        ` : `
                            <div class="bg-white rounded-2xl shadow-xl p-16 text-center border border-gray-200">
                                <svg class="mx-auto h-20 w-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="mt-4 text-xl font-bold text-gray-900">No products found</h3>
                                <p class="mt-2 text-gray-500">No completed orders in the selected period.</p>
                            </div>
                        `}
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = `
                        <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-12 text-center shadow-lg">
                            <svg class="mx-auto h-16 w-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-4 text-xl font-bold text-red-600">Error loading summary data</p>
                            <p class="text-red-500 mt-2">Please try again later</p>
                        </div>
                    `;
                });
        }
    </script>
@endsection
