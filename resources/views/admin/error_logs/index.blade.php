<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Error Logs') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-800">System Error Logs</h3>
                        <p class="text-sm text-gray-500 mt-1">Viewing recent lines from
                            <code>storage/logs/laravel.log</code>.</p>
                    </div>

                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto shadow-inner">
                        <pre class="text-xs text-green-400 font-mono whitespace-pre-wrap leading-relaxed">@forelse ($logs as $line){{ $line }}
                        @empty
    No logs found or log file is empty.
@endforelse</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>