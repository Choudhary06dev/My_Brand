@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Team Members</h1>
            <a href="{{ route('admin.team-members.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Member
            </a>
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
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Designation</th>
                            <th class="px-6 py-4">Sequence</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($teamMembers as $member)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-gray-700">{{ $member->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $member->designation ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $member->sequence }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick='openViewModal(@json($member))'
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                                            title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('admin.team-members.edit', $member->id) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.team-members.destroy', $member->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this member?');">
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
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p>No team members found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($teamMembers->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $teamMembers->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- View Member Modal -->
    <div id="viewMemberModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-white" id="modal-title">Team Member Details</h3>
                    <button type="button" class="text-indigo-100 hover:text-white focus:outline-none"
                        onclick="closeViewModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div class="sm:col-span-3 flex justify-center mb-4">
                            <img id="modalMemberPhoto" src="" alt="Member Photo"
                                class="h-32 w-32 rounded-full object-cover border-4 border-indigo-50 hidden">
                            <div id="modalMemberNoPhoto"
                                class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Member ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono" id="modalMemberId">--</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold" id="modalMemberName">--</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Designation</dt>
                            <dd class="mt-1 text-sm text-gray-900" id="modalMemberDesignation">--</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Sequence</dt>
                            <dd class="mt-1 text-sm text-gray-900" id="modalMemberSequence">--</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Bio</dt>
                            <dd class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none" id="modalMemberBio">--</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-xs font-medium text-gray-500 uppercase mb-2">Social Profiles</dt>
                            <div class="flex gap-4" id="modalMemberSocials">
                                <!-- Social icons populated via JS -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    onclick="closeViewModal()">Close</button>
                            </div> -->
            </div>
        </div>
    </div>

    <script>
        function openViewModal(member) {
            document.getElementById('modalMemberId').innerText = member.id;
            document.getElementById('modalMemberName').innerText = member.name;
            document.getElementById('modalMemberDesignation').innerText = member.designation || 'N/A';
            document.getElementById('modalMemberSequence').innerText = member.sequence;
            document.getElementById('modalMemberBio').innerText = member.bio || 'No Bio';

            const photoImg = document.getElementById('modalMemberPhoto');
            const noPhoto = document.getElementById('modalMemberNoPhoto');
            if (member.photo) {
                photoImg.src = member.photo.startsWith('http') ? member.photo : '/storage/' + member.photo;
                photoImg.classList.remove('hidden');
                noPhoto.classList.add('hidden');
            } else {
                photoImg.classList.add('hidden');
                noPhoto.classList.remove('hidden');
            }

            const socials = document.getElementById('modalMemberSocials');
            socials.innerHTML = '';
            if (member.facebook) socials.innerHTML += `<a href="${member.facebook}" target="_blank" class="text-blue-600 hover:underline">Facebook</a>`;
            if (member.linkedin) socials.innerHTML += `<a href="${member.linkedin}" target="_blank" class="text-blue-700 hover:underline">LinkedIn</a>`;
            if (member.instagram) socials.innerHTML += `<a href="${member.instagram}" target="_blank" class="text-pink-600 hover:underline">Instagram</a>`;
            if (!socials.innerHTML) socials.innerHTML = '<span class="text-gray-400 text-sm">No social profiles linked.</span>';

            document.getElementById('viewMemberModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            document.querySelector('#viewMemberModal .backdrop-blur-sm').addEventListener('click', closeViewModal);
        }

        function closeViewModal() {
            document.getElementById('viewMemberModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection