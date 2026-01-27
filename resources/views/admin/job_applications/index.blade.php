@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Job Applications</h1>
            {{-- <a href="{{ route('admin.job-applications.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Application
            </a> --}}
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
                            <th class="px-6 py-4">Applicant</th>
                            <th class="px-6 py-4">Position Applied</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($applications as $app)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 text-gray-500 font-mono text-sm">#{{ $app->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-700">{{ $app->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $app->phone }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    @if($app->job)
                                        <a href="{{ route('admin.job-openings.edit', $app->job->id) }}"
                                            class="text-indigo-600 hover:underline">
                                            {{ $app->job->title }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">Position Deleted</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $app->email }}</td>
                                <td class="px-6 py-4 text-gray-600 text-sm">{{ $app->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick='openViewModal(@json($app))'
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                                            title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <!-- <a href="{{ route('admin.job-applications.edit', $app->id) }}"
                                                                    class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-200"
                                                                    title="Edit">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                    </svg>
                                                                </a> -->

                                        @if($app->cv_file)
                                            <a href="{{ asset('storage/' . $app->cv_file) }}" target="_blank"
                                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition duration-200"
                                                title="Download CV">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        @endif

                                        <form action="{{ route('admin.job-applications.destroy', $app->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this application?');">
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
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p>No job applications found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($applications->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- View Application Modal -->
    <div id="viewAppModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div class="bg-indigo-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-white" id="modal-title">Application Details</h3>
                    <button type="button" class="text-indigo-100 hover:text-white focus:outline-none"
                        onclick="closeViewModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border-b pb-4">
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Application ID</h4>
                            <p class="mt-1 text-sm text-gray-900 font-mono" id="modalAppId">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Applicant Name</h4>
                            <p class="mt-1 text-sm text-gray-900 font-semibold" id="modalAppName">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Position Applied</h4>
                            <p class="mt-1 text-sm text-indigo-600 font-medium" id="modalAppPosition">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Email</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalAppEmail">--</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Phone</h4>
                            <p class="mt-1 text-sm text-gray-900" id="modalAppPhone">--</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-2">Cover Letter</h4>
                        <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700 whitespace-pre-wrap max-h-60 overflow-y-auto"
                            id="modalAppCover">
                            --
                        </div>
                    </div>

                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <span class="text-sm text-gray-500 font-medium">Attached CV/Resume</span>
                        <a href="#" id="modalAppCV" target="_blank"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download CV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openViewModal(app) {
            document.getElementById('modalAppId').innerText = app.id;
            document.getElementById('modalAppName').innerText = app.name;
            document.getElementById('modalAppEmail').innerText = app.email;
            document.getElementById('modalAppPhone').innerText = app.phone || 'N/A';
            document.getElementById('modalAppPosition').innerText = app.job ? app.job.title : 'Position Deleted';
            document.getElementById('modalAppCover').innerHTML = app.cover_letter || 'No Cover Letter Provided.';

            const cvLink = document.getElementById('modalAppCV');
            if (app.cv_file) {
                cvLink.href = '/storage/' + app.cv_file;
                cvLink.classList.remove('hidden');
            } else {
                cvLink.classList.add('hidden');
            }

            document.getElementById('viewAppModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            document.querySelector('#viewAppModal .backdrop-blur-sm').addEventListener('click', closeViewModal);
        }

        function closeViewModal() {
            document.getElementById('viewAppModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection