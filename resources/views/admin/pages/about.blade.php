@extends('admin.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4 py-1">About Us Page Management</h1>
            <p class="mt-2 text-gray-600 pl-5">Manage your company profile, mission, vision, and team.</p>
        </div>

        <div class="grid grid-cols-1 gap-6">

            <!-- Quick Links Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Manage Sections
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                </div>
            </div>

            <!-- Content Editing Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit About Page Content
                </h2>
                <form action="{{ route('admin.pages.about.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Image Upload Section -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">About Us Image</label>
                            <div class="mt-1 flex items-center space-x-4">
                                <div class="shrink-0">
                                    @if($companyInfo->about_image)
                                        <img class="h-16 w-16 object-cover rounded-md border border-gray-200" 
                                             src="{{ \Illuminate\Support\Str::startsWith($companyInfo->about_image, ['http', 'https']) ? $companyInfo->about_image : asset('storage/' . $companyInfo->about_image) }}" 
                                             alt="Current Image">
                                    @else
                                        <span class="inline-block h-16 w-16 rounded-md overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="about_image" id="about_image" accept="image/*"
                                        class="block w-full text-sm text-slate-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100
                                        "/>
                                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="mission" class="block text-sm font-semibold text-gray-700 mb-1">Our Mission</label>
                            <textarea name="mission" id="mission" rows="4"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                placeholder="Enter your mission statement...">{{ old('mission', $companyInfo->mission ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="vision" class="block text-sm font-semibold text-gray-700 mb-1">Our Vision</label>
                            <textarea name="vision" id="vision" rows="4"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                placeholder="Enter your vision statement...">{{ old('vision', $companyInfo->vision ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="history" class="block text-sm font-semibold text-gray-700 mb-1">History
                                Timeline</label>
                            <textarea name="history" id="history" rows="6"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                placeholder="Year - Event Description...">{{ old('history', $companyInfo->history ?? '') }}</textarea>
                            <p class="mt-2 text-xs text-gray-500 italic">Tip: Use the format <strong>"Year - Description"</strong> on each new line to create a beautiful vertical timeline on the frontend.</p>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="border-t pt-6 mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Contact Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-1">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                        placeholder="Company Name"
                                        value="{{ old('company_name', $companyInfo->company_name ?? '') }}">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                                    <input type="email" name="email" id="email" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                        placeholder="contact@company.com"
                                        value="{{ old('email', $companyInfo->email ?? '') }}">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                                    <input type="text" name="phone" id="phone" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                        placeholder="+1 (555) 123-4567"
                                        value="{{ old('phone', $companyInfo->phone ?? '') }}">
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Street Address</label>
                                    <input type="text" name="address" id="address" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                        placeholder="123 Main Street"
                                        value="{{ old('address', $companyInfo->address ?? '') }}">
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-1">City</label>
                                    <input type="text" name="city" id="city" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                        placeholder="New York"
                                        value="{{ old('city', $companyInfo->city ?? '') }}">
                                </div>

                                <div>
                                    <label for="country" class="block text-sm font-semibold text-gray-700 mb-1">Country</label>
                                    <input type="text" name="country" id="country" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150"
                                        placeholder="United States"
                                        value="{{ old('country', $companyInfo->country ?? '') }}">
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('mission');
                CKEDITOR.replace('vision');
                CKEDITOR.replace('history');
            }
        });
    </script>
@endpush
@endsection