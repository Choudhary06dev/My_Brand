@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">User Roles</h1>
            <a href="{{ route('admin.roles.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-200 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Role
            </a>
        </div>

        @if(session('success'))
            <div class="bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Content Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Role Name</th>
                            <th class="px-6 py-4">Permissions</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($roles as $role)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-500 font-mono text-sm">#{{ $role->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $role->role_name }}</td>
                                <td class="px-6 py-4">
                                    <button data-role-name="{{ $role->role_name }}"
                                        onclick="openViewModal(this.dataset.roleName, {{ $role->permissions->toJson() }})"
                                        class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-md hover:bg-indigo-100 transition duration-200">
                                        {{ $role->permissions->count() }} Privileges
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <!-- View Button -->
                                        <button data-role-name="{{ $role->role_name }}"
                                            onclick="openViewModal(this.dataset.roleName, {{ $role->permissions->toJson() }})"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                                            title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Attention: Deleting this role will affect all assigned users. Procced?');">
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
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="text-gray-400">No roles have been created yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($roles->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Simple View Role Modal -->
    <div id="viewRoleModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800" id="modalRoleName">Role Details</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors"
                        onclick="closeViewModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-6">
                    <div id="modalPermissionsList" class="grid grid-cols-1 gap-2 max-h-[60vh] overflow-y-auto">
                        <!-- Permissions will be loaded here -->
                    </div>
                </div>
                <!-- <div class="bg-gray-50 px-6 py-4 flex justify-end">
                        <button type="button"
                            class="px-4 py-2 bg-white border border-gray-300 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm"
                            onclick="closeViewModal()">
                            Close
                        </button>
                    </div> -->
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-up {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out forwards;
        }

        .animate-scale-up {
            animation: scale-up 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #CBD5E0;
        }
    </style>

    <script>
        function openViewModal(roleName, permissions) {
            document.getElementById('modalRoleName').innerText = roleName + ' Details';
            const list = document.getElementById('modalPermissionsList');
            list.innerHTML = '';

            if (permissions && permissions.length > 0) {
                permissions.forEach(p => {
                    const name = p.description || p.permission_name || p.permission_key || p.name || 'Unknown';
                    const item = document.createElement('div');
                    item.className = 'flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100';
                    item.innerHTML = `
                                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                <span class="text-sm font-medium text-gray-700">${name}</span>
                            `;
                    list.appendChild(item);
                });
            } else {
                list.className = "text-center py-8 w-full";
                list.innerHTML = `
                            <div class="text-gray-400 italic">
                                No permissions assigned.
                            </div>
                        `;
            }

            document.getElementById('viewRoleModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Close on backdrop click
            document.querySelector('#viewRoleModal .bg-gray-500').onclick = closeViewModal;
        }

        function closeViewModal() {
            document.getElementById('viewRoleModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection