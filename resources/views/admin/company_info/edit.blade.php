<x-admin-layout>


    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6">
                {{ __('Edit Company Info') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('admin.company-info.update', $companyInfo->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Company Name -->
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company
                                    Name</label>
                                <input type="text" name="company_name" id="company_name"
                                    value="{{ old('company_name', $companyInfo->company_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200"
                                    required>
                                @error('company_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tagline -->
                            <div>
                                <label for="tagline"
                                    class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                                <input type="text" name="tagline" id="tagline"
                                    value="{{ old('tagline', $companyInfo->tagline) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('tagline')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $companyInfo->email) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', $companyInfo->phone) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-6">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="address" id="address" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">{{ old('address', $companyInfo->address) }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- About -->
                        <div class="mb-6">
                            <label for="about" class="block text-sm font-medium text-gray-700 mb-2">About Us</label>
                            <textarea name="about" id="about" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">{{ old('about', $companyInfo->about) }}</textarea>
                            @error('about')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- About Image -->
                        <div class="mb-8">
                            <label for="about_image" class="block text-sm font-medium text-gray-700 mb-2">About
                                Image</label>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    @if($companyInfo->about_image)
                                        <img id="about_image_preview"
                                            class="h-24 w-32 object-cover rounded-md border border-gray-200 bg-white p-1"
                                            src="{{ \Illuminate\Support\Str::startsWith($companyInfo->about_image, ['http', 'https']) ? $companyInfo->about_image : asset('storage/' . $companyInfo->about_image) }}"
                                            alt="About image">
                                    @else
                                        <div id="about_image_placeholder"
                                            class="h-24 w-32 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <img id="about_image_preview"
                                            class="h-24 w-32 object-cover rounded-md border border-gray-200 bg-white p-1 hidden"
                                            src="#" alt="New about image preview">
                                    @endif
                                </div>
                                <label class="block">
                                    <span class="sr-only">Choose about image</span>
                                    <input type="file" name="about_image" id="about_image"
                                        onchange="previewAboutImage(this)" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                    " />
                                </label>
                            </div>
                            @error('about_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            function previewAboutImage(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        document.getElementById('about_image_preview').src = e.target.result;
                                        document.getElementById('about_image_preview').classList.remove('hidden');
                                        const placeholder = document.getElementById('about_image_placeholder');
                                        if (placeholder) placeholder.classList.add('hidden');
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Mission -->
                            <div>
                                <label for="mission"
                                    class="block text-sm font-medium text-gray-700 mb-2">Mission</label>
                                <textarea name="mission" id="mission" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">{{ old('mission', $companyInfo->mission) }}</textarea>
                                @error('mission')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Vision -->
                            <div>
                                <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">Vision</label>
                                <textarea name="vision" id="vision" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">{{ old('vision', $companyInfo->vision) }}</textarea>
                                @error('vision')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- History -->
                        <div class="mb-6">
                            <label for="history" class="block text-sm font-medium text-gray-700 mb-2">History</label>
                            <textarea name="history" id="history" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition-colors duration-200">{{ old('history', $companyInfo->history) }}</textarea>
                            @error('history')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logo -->
                        <div class="mb-8">
                            <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    @if($companyInfo->logo)
                                        <img id="logo_preview"
                                            class="h-16 w-16 object-contain rounded-full border border-gray-200 bg-white p-1"
                                            src="{{ \Illuminate\Support\Str::startsWith($companyInfo->logo, ['http', 'https']) ? $companyInfo->logo : asset('storage/' . $companyInfo->logo) }}"
                                            alt="Current profile photo">
                                    @else
                                        <div id="logo_placeholder"
                                            class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <img id="logo_preview"
                                            class="h-16 w-16 object-contain rounded-full border border-gray-200 bg-white p-1 hidden"
                                            src="#" alt="New logo preview">
                                    @endif
                                </div>
                                <label class="block">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file" name="logo" id="logo" onchange="previewLogo(this)" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                    " />
                                </label>
                            </div>
                            @error('logo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            function previewLogo(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        document.getElementById('logo_preview').src = e.target.result;
                                        document.getElementById('logo_preview').classList.remove('hidden');
                                        const placeholder = document.getElementById('logo_placeholder');
                                        if (placeholder) placeholder.classList.add('hidden');
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>


                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.company-info.index') }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Company Info
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
                CKEDITOR.replace('about');
                CKEDITOR.replace('mission');
                CKEDITOR.replace('vision');
                CKEDITOR.replace('history');
            }
        </script>
    @endpush
</x-admin-layout>