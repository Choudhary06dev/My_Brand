<x-admin-layout>


    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6">
                {{ __('Edit Service') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('admin.services.update', $service->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Service Name -->
                            <div>
                                <label for="service_name" class="block text-sm font-medium text-gray-700 mb-2">Service
                                    Name</label>
                                <input type="text" name="service_name" id="service_name"
                                    value="{{ old('service_name', $service->service_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200"
                                    required>
                                @error('service_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $service->slug) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200"
                                    required>
                                @error('slug')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Icon -->
                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon
                                    Class</label>
                                <input type="text" name="icon" id="icon" value="{{ old('icon', $service->icon) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('icon')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Banner Image -->
                            <div>
                                <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">Banner
                                    Image URL</label>
                                <input type="text" name="banner_image" id="banner_image"
                                    value="{{ old('banner_image', $service->banner_image) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('banner_image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Sequence -->
                            <div>
                                <label for="sequence" class="block text-sm font-medium text-gray-700 mb-2">Sequence
                                    Order</label>
                                <input type="number" name="sequence" id="sequence"
                                    value="{{ old('sequence', $service->sequence) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('sequence')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                    <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>


                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.services.index') }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.getElementById('service_name').addEventListener('keyup', function () {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof CKEDITOR !== 'undefined') {
                    CKEDITOR.replace('description');
                }
            });
        </script>
    @endpush
</x-admin-layout>