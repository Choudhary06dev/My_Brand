@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Sliders</h1>
            <a href="{{ route('admin.sliders.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Slider
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
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Image</th>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Sequence</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($sliders as $slider)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-500 font-mono text-sm">#{{ $slider->id }}</td>
                                <td class="px-6 py-4">
                                    @if($slider->image)
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="w-20 h-12 object-cover rounded">
                                    @else
                                        <div class="w-20 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-700">{{ $slider->title }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($slider->subtitle, 40) }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $slider->sequence }}</td>
                                <td class="px-6 py-4">
                                    @if($slider->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick='openViewModal(@json($slider))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('admin.sliders.edit', $slider->id) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this slider?');">
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
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p>No sliders found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sliders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $sliders->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- View Slider Modal -->
    <div id="viewSliderModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                 <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-white" id="modal-title">Slider Details</h3>
                    <button type="button" class="text-indigo-100 hover:text-white focus:outline-none" onclick="closeViewModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="mb-4">
                        <img id="modalSliderImage" src="" alt="Slider Image" class="w-full h-64 object-cover rounded-lg">
                        <p id="modalSliderNoImage" class="hidden text-center text-gray-500 py-16">No Image</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">ID</h4>
                            <p class="mt-1 text-sm text-gray-900 font-mono" id="modalSliderId">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Title</h4>
                            <p class="mt-1 text-sm text-gray-900 font-semibold" id="modalSliderTitle">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Sequence</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalSliderSequence">--</p>
                        </div>
                        <div class="md:col-span-2">
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Subtitle</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalSliderSubtitle">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Button Text</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalSliderButtonText">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Button Link</h4>
                            <p class="mt-1 text-sm text-blue-600" id="modalSliderButtonLink">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Status</h4>
                            <p class="mt-1" id="modalSliderStatus">--</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openViewModal(slider) {
            document.getElementById('modalSliderId').innerText = slider.id;
            document.getElementById('modalSliderTitle').innerText = slider.title || 'No Title';
            document.getElementById('modalSliderSubtitle').innerText = slider.subtitle || 'No Subtitle';
            document.getElementById('modalSliderSequence').innerText = slider.sequence;
            document.getElementById('modalSliderButtonText').innerText = slider.button_text || 'N/A';
            document.getElementById('modalSliderButtonLink').innerText = slider.button_link || 'N/A';

            const statusElem = document.getElementById('modalSliderStatus');
            if (slider.status) {
                statusElem.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>';
            } else {
                statusElem.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>';
            }

            const imgElem = document.getElementById('modalSliderImage');
            const noImgElem = document.getElementById('modalSliderNoImage');
            if (slider.image) {
                imgElem.src = '/storage/' + slider.image;
                imgElem.classList.remove('hidden');
                noImgElem.classList.add('hidden');
            } else {
                imgElem.classList.add('hidden');
                noImgElem.classList.remove('hidden');
            }

            document.getElementById('viewSliderModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            document.querySelector('#viewSliderModal .backdrop-blur-sm').addEventListener('click', closeViewModal);
        }

        function closeViewModal() {
            document.getElementById('viewSliderModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
