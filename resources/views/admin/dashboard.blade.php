@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                Dashboard Overview
            </h2>
            <p class="text-gray-500 mt-1">Welcome back, get a quick update on your store's performance.</p>
        </div>
        <div>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-lg shadow-indigo-600/20 font-medium transition-all transform hover:-translate-y-0.5">
                Generate Report
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-shadow border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">+12.5%</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Revenue</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">$45,231.89</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-shadow border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">+8.2%</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Orders</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">1,205</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-shadow border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">+2.4%</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Active Customer</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">8,432</p>
        </div>

         <!-- Card 4 -->
         <div class="bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-shadow border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-sm font-medium text-red-600 bg-red-50 px-2.5 py-1 rounded-full">-1.2%</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Pending Issues</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">23</p>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart Area (Placeholder) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-gray-800">Revenue Analytics</h3>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2">
                    <option>Last 7 days</option>
                    <option>Last Month</option>
                    <option>Last Year</option>
                </select>
            </div>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-400">Chart Visualization Placeholder</p>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 p-6">
             <h3 class="font-bold text-gray-800 mb-4">Recent Activity</h3>
             <div class="space-y-4">
                 <!-- Activity Item -->
                 <div class="flex items-start gap-3">
                     <div class="w-2 h-2 mt-2 rounded-full bg-indigo-500"></div>
                     <div>
                         <p class="text-sm text-gray-700">New order <span class="font-semibold">#ORDER-245</span> received from <span class="font-semibold">Sara Smith</span></p>
                         <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                     </div>
                 </div>
                 <div class="flex items-start gap-3">
                     <div class="w-2 h-2 mt-2 rounded-full bg-emerald-500"></div>
                     <div>
                         <p class="text-sm text-gray-700">Payment of <span class="font-semibold">$120.00</span> verified</p>
                         <p class="text-xs text-gray-400 mt-1">15 minutes ago</p>
                     </div>
                 </div>
                 <div class="flex items-start gap-3">
                     <div class="w-2 h-2 mt-2 rounded-full bg-amber-500"></div>
                     <div>
                         <p class="text-sm text-gray-700">Product <span class="font-semibold">Nike Air Max</span> low stock warning</p>
                         <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                     </div>
                 </div>
             </div>
             <button class="w-full mt-6 py-2 text-sm text-indigo-600 font-medium hover:text-indigo-800 transition-colors">View All Activity</button>
        </div>
    </div>
@endsection
