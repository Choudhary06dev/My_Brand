<x-admin-layout>


    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6">
                {{ __('Edit Team Member') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('admin.team-members.update', $teamMember->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $teamMember->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200"
                                    required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Designation -->
                            <div>
                                <label for="designation"
                                    class="block text-sm font-medium text-gray-700 mb-2">Designation</label>
                                <input type="text" name="designation" id="designation"
                                    value="{{ old('designation', $teamMember->designation) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('designation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mb-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea name="bio" id="bio" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">{{ old('bio', $teamMember->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Photo -->
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                                @if($teamMember->photo)
                                    <div class="mb-2">
                                            <img src="{{ asset('storage/' . $teamMember->photo) }}" alt="Current Photo"
                                            class="h-20 w-auto rounded object-cover shadow-sm">
                                    </div>
                                @endif
                                <input type="file" name="photo" id="photo" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current photo.</p>
                                @error('photo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sequence -->
                            <div>
                                <label for="sequence" class="block text-sm font-medium text-gray-700 mb-2">Sequence
                                    Order</label>
                                <input type="number" name="sequence" id="sequence"
                                    value="{{ old('sequence', $teamMember->sequence) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('sequence')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <!-- Facebook -->
                            <div>
                                <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook
                                    Profile</label>
                                <input type="text" name="facebook" id="facebook"
                                    value="{{ old('facebook', $teamMember->facebook) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                            </div>
                            <!-- LinkedIn -->
                            <div>
                                <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn
                                    Profile</label>
                                <input type="text" name="linkedin" id="linkedin"
                                    value="{{ old('linkedin', $teamMember->linkedin) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                            </div>
                            <!-- Instagram -->
                            <div>
                                <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">Instagram
                                    Profile</label>
                                <input type="text" name="instagram" id="instagram"
                                    value="{{ old('instagram', $teamMember->instagram) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                            </div>
                        </div>


                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.team-members.index') }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Team Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('bio');
            }
        </script>
    @endpush
</x-admin-layout>