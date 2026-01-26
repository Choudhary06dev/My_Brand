@extends('admin.layouts.app')

@section('title', 'Customer Management')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-10">
        <h2 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent tracking-tight">
            Customers
        </h2>
        <p class="text-gray-500 mt-2 text-lg">Maintain your customer relationships and view their history.</p>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_-20px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 backdrop-blur-sm text-gray-400 text-xs uppercase tracking-[0.1em] font-bold">
                    <tr>
                        <th class="px-8 py-6">Customer</th>
                        <th class="px-8 py-6">Email</th>
                        <th class="px-8 py-6">Joined</th>
                        <th class="px-8 py-6 text-center">Orders</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($customers as $customer)
                        <tr class="group hover:bg-indigo-50/30 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ substr($customer->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-gray-500">
                                {{ $customer->email }}
                            </td>
                            <td class="px-8 py-6 text-gray-500">
                                {{ $customer->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-xs font-bold">
                                    {{ $customer->orders_count }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="inline-flex items-center text-indigo-600 font-bold hover:underline opacity-0 group-hover:opacity-100 transition-opacity">
                                    View History →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-gray-500 font-medium">
                                No customers registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
            <div class="px-8 py-6 bg-gray-50/50">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
