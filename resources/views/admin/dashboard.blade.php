<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div
                class="mb-10 bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 rounded-3xl shadow-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-white/5 backdrop-blur-3xl"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2">Welcome {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-lg text-indigo-100">Here's what's happening with your website today.</p>
                </div>
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute right-24 -top-10 w-36 h-36 bg-purple-400/20 rounded-full blur-xl"></div>
            </div>

            <!-- Key Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">


                <!-- Contact Messages -->
                <div
                    class="group bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-slate-500 mb-2">Contact Messages</p>
                                <p
                                    class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    {{ number_format($contactMessagesCount) }}
                                </p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center text-sm text-slate-500">
                            <span class="inline-flex items-center text-emerald-600 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Inbox
                            </span>
                            <span class="ml-2">messages received</span>
                        </div>
                    </div>
                </div>

                <!-- Job Applications -->
                <div
                    class="group bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-slate-500 mb-2">Job Applications</p>
                                <p
                                    class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent">
                                    {{ number_format($jobApplicationsCount) }}
                                </p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center text-sm text-slate-500">
                            <span class="inline-flex items-center text-amber-600 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                                Applications
                            </span>
                            <span class="ml-2">received</span>
                        </div>
                    </div>
                </div>

                <!-- Published News -->
                <div
                    class="group bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-slate-500 mb-2">Published News</p>
                                <p
                                    class="text-4xl font-bold bg-gradient-to-r from-rose-500 to-pink-600 bg-clip-text text-transparent">
                                    {{ number_format($newsCount) }}
                                </p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 text-white shadow-lg shadow-rose-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center text-sm text-slate-500">
                            <span class="inline-flex items-center text-rose-600 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z"
                                        clip-rule="evenodd" />
                                    <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                                </svg>
                                Articles
                            </span>
                            <span class="ml-2">published</span>
                        </div>
                    </div>
                </div>

                <!-- Total Visitors -->
                <div
                    class="group bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-white/50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-slate-500 mb-2">Total Visitors</p>
                                <p
                                    class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    {{ number_format($visitorsCount) }}
                                </p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center text-sm text-slate-500">
                            <span class="inline-flex items-center text-blue-600 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.523 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Tracking
                            </span>
                            <span class="ml-2">unique visits</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Quick Links -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Recent Activity Logs -->
                <div
                    class="lg:col-span-2 bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center">
                                <div
                                    class="p-2 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white mr-3">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Recent Activity Logs
                            </h3>
                            <a href="{{ route('admin.activity-logs.index') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                View All
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                            User</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                            Action</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                            Time</th>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                            View</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($recentActivities as $activity)
                                        <tr class="hover:bg-slate-50/50 transition duration-200">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-medium">
                                                        {{ $activity->user ? substr($activity->user->name, 0, 1) : 'S' }}
                                                    </div>
                                                    <span class="ml-3 text-sm font-medium text-slate-700">
                                                        {{ $activity->user ? $activity->user->name : 'System' }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $activity->action }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-right">
                                                <button onclick='openActivityModal(@json($activity))'
                                                    class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                                    title="View Details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center text-slate-400">
                                                    <div class="p-4 rounded-full bg-slate-100 mb-4">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-sm font-medium">No recent activity found</p>
                                                    <p class="text-xs mt-1">Activities will appear here once there's any
                                                        action</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / System Management -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/50 overflow-hidden h-fit">
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-8 flex items-center">
                            <div class="p-2 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white mr-3">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            System Management
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.email-templates.index') }}"
                                class="flex items-center w-full px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:scale-[1.02] transition-all duration-300 font-medium">
                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Manage Email Templates
                            </a>
                            <a href="{{ route('admin.error-logs.index') }}"
                                class="flex items-center w-full px-4 py-3 bg-white border-2 border-slate-200 text-slate-700 rounded-xl hover:border-rose-300 hover:bg-rose-50 hover:text-rose-700 transition-all duration-300 font-medium">
                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                View Error Logs
                            </a>
                            <a href="{{ route('admin.activity-logs.index') }}"
                                class="flex items-center w-full px-4 py-3 bg-white border-2 border-slate-200 text-slate-700 rounded-xl hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-300 font-medium">
                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                View Activity Logs
                            </a>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- View Activity Modal -->
    <div id="viewActivityModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white" id="modal-title">Activity Details</h3>
                    <button type="button" class="text-white/80 hover:text-white focus:outline-none transition-colors"
                        onclick="closeActivityModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-5 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-slate-500 mb-1">User</dt>
                            <dd class="text-sm font-semibold text-slate-900" id="modalActivityUser">--</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-slate-500 mb-1">IP Address</dt>
                            <dd class="text-sm font-mono text-slate-900 bg-slate-100 px-2 py-1 rounded inline-block"
                                id="modalActivityIP">--</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500 mb-1">Action</dt>
                            <dd class="text-sm text-slate-900" id="modalActivityAction">--</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500 mb-1">Description</dt>
                            <dd class="text-sm text-slate-900 break-words" id="modalActivityDescription">--</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500 mb-1">Time</dt>
                            <dd class="text-sm text-slate-900" id="modalActivityTime">--</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openActivityModal(activity) {
            document.getElementById('modalActivityUser').innerText = activity.user ? activity.user.name : 'System';
            document.getElementById('modalActivityIP').innerText = activity.ip_address || 'N/A';
            document.getElementById('modalActivityAction').innerText = activity.action;
            document.getElementById('modalActivityDescription').innerText = activity.description || 'No description';
            document.getElementById('modalActivityTime').innerText = new Date(activity.created_at).toLocaleString();

            document.getElementById('viewActivityModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            document.querySelector('#viewActivityModal .backdrop-blur-sm').addEventListener('click', closeActivityModal);
        }

        function closeActivityModal() {
            document.getElementById('viewActivityModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-admin-layout>