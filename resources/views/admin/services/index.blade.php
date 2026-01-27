@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Services</h1>
            <a href="{{ route('admin.services.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Service
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
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($services as $service)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-500 font-mono text-sm">#{{ $service->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-700">{{ $service->service_name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $service->slug }}</td>
                                <td class="px-6 py-4">
                                    @if($service->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick='openViewModal(@json($service))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('admin.services.edit', $service->id) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this service?');">
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
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <p>No services found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($services->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- View Service Modal -->
    <div id="viewServiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-white" id="modal-title">Service Details</h3>
                    <button type="button" class="text-indigo-100 hover:text-white focus:outline-none" onclick="closeViewModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="col-span-1">
                             <dt class="text-xs font-medium text-gray-500 uppercase">Service ID</dt>
                             <dd class="mt-1 text-sm text-gray-900 font-mono" id="modalServiceId">--</dd>
                        </div>
                        <div class="col-span-1">
                             <dt class="text-xs font-medium text-gray-500 uppercase">Service Name</dt>
                             <dd class="mt-1 text-sm text-gray-900" id="modalServiceName">--</dd>
                        </div>
                        <div class="col-span-1">
                             <dt class="text-xs font-medium text-gray-500 uppercase">Slug</dt>
                             <dd class="mt-1 text-sm text-gray-900 font-mono" id="modalServiceSlug">--</dd>
                        </div>
                        <div class="col-span-1">
                             <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                             <dd class="mt-1 text-sm text-gray-900" id="modalServiceStatus">--</dd>
                        </div>
                        <div class="col-span-1">
                             <dt class="text-xs font-medium text-gray-500 uppercase">Icon</dt>
                             <dd class="mt-1 text-sm text-gray-900 font-mono text-xs truncate" id="modalServiceIcon">--</dd>
                        </div>
                        <div class="col-span-2">
                             <dt class="text-xs font-medium text-gray-500 uppercase">Banner Image</dt>
                             <dd class="mt-1 text-sm text-gray-900 break-all" id="modalServiceBanner">--</dd>
                        </div>
                         <div class="col-span-2">
                             <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                             <dd class="mt-1 text-sm text-gray-900 prose prose-indigo max-w-none" id="modalServiceDescription">--</dd>
                        </div>
                    </div>
                </div>
                <!-- <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" onclick="closeViewModal()">Close</button>
                </div> -->
            </div>
        </div>
    </div>

    <script>
        function openViewModal(service) {
            document.getElementById('modalServiceId').innerText = service.id;
            document.getElementById('modalServiceName').innerText = service.service_name;
            document.getElementById('modalServiceSlug').innerText = service.slug;
            document.getElementById('modalServiceIcon').innerText = service.icon || 'No Icon';
            document.getElementById('modalServiceBanner').innerText = service.banner_image || 'No Image';
             document.getElementById('modalServiceDescription').innerHTML = service.description || 'No Description';
            
            const statusElem = document.getElementById('modalServiceStatus');
            if (service.status) {
                statusElem.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>';
            } else {
                statusElem.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>';
            }

            document.getElementById('viewServiceModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            document.querySelector('#viewServiceModal .backdrop-blur-sm').addEventListener('click', closeViewModal);
        }

        function closeViewModal() {
            document.getElementById('viewServiceModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
