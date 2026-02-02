@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-6">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.returns.index') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-900 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Return Request Detail</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Request Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Request Info</h2>
                    <span class="text-gray-400 font-bold">REQ-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Reason for Return</p>
                        <p class="font-bold text-indigo-600">{{ $request->reason }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Submitted On</p>
                        <p class="font-bold text-gray-800">{{ $request->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Customer Message</p>
                    <div class="bg-gray-50 p-6 rounded-2xl text-gray-700 italic border border-gray-100 font-medium">
                        "{{ $request->description }}"
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Evidence Photos</p>
                    <div class="grid grid-cols-3 gap-4">
                        @if($request->images)
                            @foreach($request->images as $image)
                                <a href="{{ asset('storage/' . $image) }}" target="_blank" class="group relative rounded-2xl overflow-hidden aspect-square border-2 border-gray-100">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Proof" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <p class="text-sm font-bold text-gray-400 italic">No photos uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Items Info -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-xl font-black text-gray-900 mb-8 uppercase tracking-tight">Order Items</h2>
                <div class="space-y-6">
                    @foreach($request->order->items as $item)
                        <div class="flex items-center gap-6 pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                            <div class="w-20 h-20 bg-gray-50 rounded-2xl overflow-hidden border border-gray-100">
                                <img src="{{ asset('storage/' . $item->product->main_image) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900">{{ $item->product->product_name }}</h4>
                                <p class="text-sm text-gray-500 font-bold">Qty: {{ $item->quantity }} | Total: Rs. {{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Status Management -->
        <div class="space-y-6">
            <div class="bg-gray-900 rounded-3xl p-8 text-white shadow-xl shadow-gray-200">
                <h2 class="text-lg font-black mb-8 uppercase tracking-widest">Update Status</h2>
                
                <form action="{{ route('admin.returns.update-status', $request->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Request Status</label>
                        <select name="status" class="w-full bg-white/10 border border-white/10 rounded-2xl px-5 py-4 font-bold text-white outline-none focus:border-indigo-400 transition-colors">
                            <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }} class="text-black">Pending</option>
                            <option value="approved" {{ $request->status === 'approved' ? 'selected' : '' }} class="text-black">Approved</option>
                            <option value="qc_in_progress" {{ $request->status === 'qc_in_progress' ? 'selected' : '' }} class="text-black">QC In Progress</option>
                            <option value="refunded" {{ $request->status === 'refunded' ? 'selected' : '' }} class="text-black">Refunded</option>
                            <option value="rejected" {{ $request->status === 'rejected' ? 'selected' : '' }} class="text-black">Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Internal Remarks</label>
                        <textarea name="admin_remark" rows="4" class="w-full bg-white/10 border border-white/10 rounded-2xl px-5 py-4 font-medium text-white outline-none focus:border-indigo-400 transition-colors resize-none" placeholder="Add remarks for the customer...">{{ $request->admin_remark }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 px-8 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        Update Request
                    </button>
                </form>
            </div>

            <div class="bg-indigo-50 rounded-3xl p-8 border border-indigo-100">
                <h3 class="text-indigo-900 font-black mb-4 uppercase text-xs tracking-widest">Customer Details</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-indigo-600 font-black text-xl border border-indigo-100 shadow-sm">
                        {{ strtoupper(substr($request->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-black text-indigo-950">{{ $request->user->name }}</p>
                        <p class="text-xs text-indigo-400 font-bold">{{ $request->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
