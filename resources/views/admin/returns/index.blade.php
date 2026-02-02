@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Return Requests</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs font-black uppercase text-gray-500 tracking-widest">
                        <th class="px-6 py-4">Request #</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Order #</th>
                        <th class="px-6 py-4">Reason</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $request)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-black text-indigo-600">REQ-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 font-bold text-gray-700">{{ $request->user->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $request->order->order_number }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-3 py-1 rounded-full uppercase">{{ $request->reason }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        'qc_in_progress' => 'bg-blue-100 text-blue-700',
                                        'refunded' => 'bg-emerald-100 text-emerald-700',
                                    ];
                                    $class = $statusClasses[$request->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="{{ $class }} text-[10px] font-black px-3 py-1 rounded-full uppercase">{{ str_replace('_', ' ', $request->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $request->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.returns.show', $request->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg inline-flex items-center gap-2">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 font-bold">No return requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
