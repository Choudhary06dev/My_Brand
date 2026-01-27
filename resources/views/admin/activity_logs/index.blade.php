<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/50 overflow-hidden">
                <div class="p-8">
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
                                        Description</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        IP</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($activities as $activity)
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
                                            {{ $activity->description ?? '—' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $activity->ip_address ?? '—' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right">
                                            <button onclick='openActivityModal(@json($activity))' class='p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200' title='View Details'>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                                            No activity logs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<!-- Activity Details Modal (same as dashboard) -->
<div id="viewActivityModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm"></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white" id="modal-title">Activity Details</h3>
                <button type="button" class="text-white/80 hover:text-white focus:outline-none transition-colors" onclick="closeActivityModal()">
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
                        <dd class="text-sm font-mono text-slate-900 bg-slate-100 px-2 py-1 rounded inline-block" id="modalActivityIP">--</dd>
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