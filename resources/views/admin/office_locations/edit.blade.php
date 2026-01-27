@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800 tracking-tight">Edit Office</h1>
            <p class="text-gray-500 text-sm mt-1">Update the details for "{{ $officeLocation->title }}".</p>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('admin.office-locations.update', $officeLocation->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Office Title <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('title') border-red-500 @enderror"
                                    value="{{ old('title', $officeLocation->title) }}" required>
                                @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Address <span
                                        class="text-red-500">*</span></label>
                                <textarea name="address" rows="3"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('address') border-red-500 @enderror"
                                    required>{{ old('address', $officeLocation->address) }}</textarea>
                                @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                                <input type="text" name="city"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('city') border-red-500 @enderror"
                                    value="{{ old('city', $officeLocation->city) }}" placeholder="e.g. Dubai">
                                @error('city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                                <input type="text" name="country"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('country') border-red-500 @enderror"
                                    value="{{ old('country', $officeLocation->country) }}" placeholder="e.g. UAE">
                                @error('country') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('email') border-red-500 @enderror"
                                    value="{{ old('email', $officeLocation->email) }}">
                                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <input type="text" name="phone"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('phone') border-red-500 @enderror"
                                    value="{{ old('phone', $officeLocation->phone) }}">
                                @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Display Sequence <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="sequence"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('sequence') border-red-500 @enderror"
                                    value="{{ old('sequence', $officeLocation->sequence) }}" required>
                                @error('sequence') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span
                                        class="text-red-500">*</span></label>
                                <select name="status"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('status') border-red-500 @enderror"
                                    required>
                                    <option value="1" {{ old('status', $officeLocation->status) == '1' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('status', $officeLocation->status) == '0' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.office-locations.index') }}"
                                class="px-6 py-2.5 rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200 transition duration-200 font-medium">Cancel</a>
                            <button type="submit"
                                class="px-6 py-2.5 rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg transition duration-200 font-semibold">Update
                                Office</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection