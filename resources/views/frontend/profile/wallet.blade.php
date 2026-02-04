@extends('frontend.layouts.app')

@section('title', 'My Wallet - ' . config('app.name'))

@section('content')
<div class="bg-gray-50/50 min-h-screen py-12">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">My Wallet</h1>
                    <p class="text-sm text-gray-500 font-medium">Manage your balance and view transaction history.</p>
                </div>
            </div>

            <!-- Balance Card -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-8 mb-8 text-white shadow-xl shadow-indigo-200">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-indigo-100 font-bold mb-1 uppercase tracking-widest text-xs">Current Balance</p>
                        <h2 class="text-5xl font-black tracking-tighter">
                            <span class="text-2xl font-bold opacity-70">{{ $company->currency_symbol ?? 'PKR' }}</span> {{ number_format(Auth::user()->wallet_balance, 2) }}
                        </h2>
                    </div>
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            <h3 class="text-xl font-bold text-gray-900 mb-6">Transaction History</h3>

            @if($transactions->count() > 0)
                <div class="bg-white rounded-3xl border border-gray-100 shadow-lg shadow-gray-200/20 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-left">
                                    <th class="py-4 px-6 text-[10px] uppercase tracking-widest font-black text-gray-400">Date</th>
                                    <th class="py-4 px-6 text-[10px] uppercase tracking-widest font-black text-gray-400">Description</th>
                                    <th class="py-4 px-6 text-[10px] uppercase tracking-widest font-black text-gray-400">Type</th>
                                    <th class="py-4 px-6 text-[10px] uppercase tracking-widest font-black text-gray-400 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($transactions as $transaction)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 px-6">
                                            <span class="text-xs font-bold text-gray-700">{{ $transaction->created_at->format('d M, Y') }}</span>
                                            <span class="block text-[10px] text-gray-400 font-medium">{{ $transaction->created_at->format('h:i A') }}</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <p class="text-sm font-bold text-gray-900">{{ $transaction->description ?? 'N/A' }}</p>
                                            @if($transaction->reference_id)
                                                <span class="text-[10px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full mt-1 inline-block">Ref: #{{ $transaction->reference_id }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($transaction->type === 'credit')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-green-50 text-green-600 border border-green-100">
                                                    <i class="fas fa-arrow-down text-[8px] mr-1"></i> CREDIT
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-red-50 text-red-600 border border-red-100">
                                                    <i class="fas fa-arrow-up text-[8px] mr-1"></i> DEBIT
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <span class="text-sm font-black {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type === 'credit' ? '+' : '-' }} {{ number_format($transaction->amount, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-16 text-center shadow-2xl shadow-gray-200/50 border border-gray-100 flex flex-col items-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-receipt text-4xl text-gray-300"></i>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 mb-3">No Transactions Yet</h2>
                    <p class="text-sm text-gray-500 max-w-sm font-medium leading-relaxed">Your wallet transaction history will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
