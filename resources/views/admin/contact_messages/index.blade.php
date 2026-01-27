@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Contact Messages</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($messages as $message)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-500 font-mono text-sm">#{{ $message->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-700">{{ $message->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $message->email }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ Str::limit($message->subject ?? 'No Subject', 30) }}</td>
                                <td class="px-6 py-4">
                                    @if($message->is_read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Read
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            New
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">{{ $message->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick='openViewModal(@json($message))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        
                                        <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                                title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p>No contact messages found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($messages->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- View Message Modal -->
    <div id="viewMessageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                 <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-white" id="modal-title">Message Details</h3>
                    <button type="button" class="text-indigo-100 hover:text-white focus:outline-none" onclick="closeViewModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Message ID</h4>
                            <p class="mt-1 text-sm text-gray-900 font-mono" id="modalMessageId">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Sender Name</h4>
                            <p class="mt-1 text-sm text-gray-900 font-semibold" id="modalMsgName">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Date Received</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalMsgDate">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Email</h4>
                            <p class="mt-1 text-sm text-blue-600 font-medium" id="modalMsgEmail">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Phone</h4>
                            <p class="mt-1 text-sm text-gray-900 font-medium" id="modalMsgPhone">--</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Subject</h4>
                        <p class="mt-1 text-sm text-gray-900 font-medium border-b pb-2" id="modalMsgSubject">--</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-2">Message</h4>
                        <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700 whitespace-pre-wrap max-h-60 overflow-y-auto border border-gray-100" id="modalMsgBody">
                            --
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                        <button type="button" class="inline-flex justify-center items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors duration-200" onclick="closeViewModal()">Close View</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openViewModal(message) {
            document.getElementById('modalMessageId').innerText = message.id;
            document.getElementById('modalMsgName').innerText = message.name;
            document.getElementById('modalMsgEmail').innerText = message.email;
            document.getElementById('modalMsgPhone').innerText = message.phone || 'N/A';
            document.getElementById('modalMsgSubject').innerText = message.subject || 'No Subject';
            document.getElementById('modalMsgBody').innerText = message.message;
            document.getElementById('modalMsgDate').innerText = new Date(message.created_at).toLocaleString();

            document.getElementById('viewMessageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            if(!message.is_read) {
                 fetch(`{{ url('admin/contact-messages') }}/${message.id}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                 });
            }
            
            document.querySelector('#viewMessageModal .backdrop-blur-sm').addEventListener('click', closeViewModal);
        }

        function closeViewModal() {
            document.getElementById('viewMessageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
