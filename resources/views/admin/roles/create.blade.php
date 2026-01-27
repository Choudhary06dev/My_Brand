<x-admin-layout>
    <div class="container-fluid p-6">
        <!-- Header Section -->
        <div class="mb-6">
            <!-- <a href="{{ route('admin.roles.index') }}"
                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors mb-3 gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Roles List
            </a> -->
            <h1 class="text-2xl font-semibold text-gray-800 tracking-tight">Create New Role</h1>
            <p class="text-gray-500 text-sm mt-1">Define system access levels and assign specific tool permissions.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-5xl">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf

                <div class="p-6 md:p-8">
                    <!-- Role Name -->
                    <div class="mb-8">
                        <label for="role_name" class="block text-sm font-semibold text-gray-700 mb-2">Role Name</label>
                        <input type="text" name="role_name" id="role_name"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 transition-all duration-200"
                            placeholder="e.g. Administrator, Editor" required autofocus>
                        @error('role_name')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Permissions Grid -->
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                            <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Module Permissions</h4>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="checkbox" id="selectAllPermissions"
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                                <span
                                    class="ml-2 text-sm font-medium text-gray-600 group-hover:text-indigo-600 transition-colors">Select
                                    All</span>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($permissions as $permission)
                                <label
                                    class="flex items-start gap-3 p-4 rounded-xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:border-indigo-100 hover:shadow-sm transition-all duration-200 cursor-pointer group">
                                    <div class="mt-0.5">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            id="perm_{{ $permission->id }}"
                                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer permission-checkbox">
                                    </div>
                                    <div>
                                        <span
                                            class="block text-sm font-semibold text-gray-700 group-hover:text-indigo-700 transition-colors">
                                            {{ $permission->description ?? $permission->permission_key ?? $permission->name }}
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.roles.index') }}"
                        class="px-5 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 transition-all duration-200">
                        Save Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAllPermissions');
            const checkboxes = document.querySelectorAll('.permission-checkbox');

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    selectAll.checked = allChecked;
                });
            });
        });
    </script>
</x-admin-layout>