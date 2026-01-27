<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Visitors Tracking') }}
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
                                        IP Address
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        User Agent
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Page URL
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Visited At
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($visitors as $visitor)
                                    <tr class="hover:bg-slate-50/50 transition duration-200">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="text-sm font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded">
                                                {{ $visitor->ip_address }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="text-xs text-slate-500 break-all"
                                                title="{{ $visitor->user_agent }}">
                                                {{ Str::limit($visitor->user_agent, 50) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-slate-600">
                                            <a href="{{ $visitor->page_url }}" target="_blank"
                                                class="hover:text-indigo-600 transition-colors">
                                                {{ Str::limit($visitor->page_url, 40) }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $visitor->created_at->diffForHumans() }}
                                            <div class="text-[10px] text-slate-400">
                                                {{ $visitor->created_at->format('M d, Y H:i:s') }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-12 text-center text-slate-400">
                                            No visitor records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        {{ $visitors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>