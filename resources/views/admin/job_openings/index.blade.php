@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Job Openings</h1>
            <a href="{{ route('admin.job-openings.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Job Opening
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
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Department</th>
                            <th class="px-6 py-4">Job Type</th>
                            <th class="px-6 py-4">Location</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jobOpenings as $job)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-500 font-mono text-sm">#{{ $job->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-700">{{ $job->title }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $job->department ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $job->job_type ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $job->location ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($job->status)
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
                                        <button onclick='openViewModal(@json($job))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('admin.job-openings.edit', $job->id) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.job-openings.destroy', $job->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this job opening?');">
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
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p>No job openings found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($jobOpenings->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $jobOpenings->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- View Job Modal -->
    <div id="viewJobModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                 <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-white" id="modal-title">Job Details</h3>
                    <button type="button" class="text-indigo-100 hover:text-white focus:outline-none" onclick="closeViewModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-4 mb-4">
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">ID</h4>
                            <p class="mt-1 text-sm text-gray-900 font-mono" id="modalJobId">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Title</h4>
                            <p class="mt-1 text-lg text-gray-900 font-bold" id="modalJobTitle">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Status</h4>
                            <p class="mt-1" id="modalJobStatus">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Department</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalJobDepartment">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Job Type</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalJobType">--</p>
                        </div>
                         <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Location</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalJobLocation">--</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 uppercase bg-gray-50 p-2 rounded">Description</h4>
                            <div class="mt-1 text-sm text-gray-700 whitespace-pre-line p-2" id="modalJobDescription">--</div>
                        </div>
                         <div>
                            <h4 class="text-sm font-semibold text-gray-800 uppercase bg-gray-50 p-2 rounded">Responsibilities</h4>
                            <div class="mt-1 text-sm text-gray-700 whitespace-pre-line p-2" id="modalJobResponsibilities">--</div>
                        </div>
                         <div>
                            <h4 class="text-sm font-semibold text-gray-800 uppercase bg-gray-50 p-2 rounded">Qualifications</h4>
                            <div class="mt-1 text-sm text-gray-700 whitespace-pre-line p-2" id="modalJobQualifications">--</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openViewModal(job) {
            document.getElementById('modalJobId').innerText = job.id;
            document.getElementById('modalJobTitle').innerText = job.title;
            document.getElementById('modalJobDepartment').innerText = job.department || 'N/A';
            document.getElementById('modalJobType').innerText = job.job_type || 'N/A';
            document.getElementById('modalJobLocation').innerText = job.location || 'N/A';
            document.getElementById('modalJobDescription').innerHTML = job.description || 'N/A';
            document.getElementById('modalJobResponsibilities').innerHTML = job.responsibilities || 'N/A';
            document.getElementById('modalJobQualifications').innerHTML = job.qualifications || 'N/A';

            const statusElem = document.getElementById('modalJobStatus');
            if (job.status) {
                statusElem.innerHTML = '<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800\">Active</span>';
            } else {
                statusElem.innerHTML = '<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800\">Inactive</span>';
            }

            document.getElementById('viewJobModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            document.querySelector('#viewJobModal .backdrop-blur-sm').addEventListener('click', closeViewModal);
        }

        function closeViewModal() {
            document.getElementById('viewJobModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
