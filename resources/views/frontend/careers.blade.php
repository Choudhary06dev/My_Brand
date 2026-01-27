@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-100 py-12">
        <div class="container-custom">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h1 class="text-4xl font-extrabold text-gray-900 mb-6 text-center">Careers</h1>
            <p class="text-center text-gray-600 max-w-2xl mx-auto mb-12">Join our dynamic team and help us shape the future.
            </p>

            @if($jobs->count() > 0)
                <div class="space-y-6 max-w-4xl mx-auto">
                    @foreach($jobs as $job)
                        <div
                            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-indigo-500">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">{{ $job->title }}</h2>
                                    <div class="text-sm text-gray-500 mt-1 flex gap-4">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $job->department }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $job->location ?? 'Remote' }}
                                        </span>
                                        <span
                                            class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs font-semibold self-center">
                                            {{ $job->job_type ?? 'Full Time' }}
                                        </span>
                                    </div>
                                </div>
                                <button onclick="openApplyModal({{ $job->id }}, '{{ addslashes($job->title) }}')"
                                    class="mt-4 md:mt-0 bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                    Apply Now
                                </button>
                            </div>

                            <div class="text-gray-600 mb-4 prose max-w-none">
                                {!! \Illuminate\Support\Str::limit(strip_tags($job->description), 250) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-10 text-center max-w-2xl mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No Openings Currently</h3>
                    <p class="text-gray-600">We don't have any open positions right now, but please check back soon or send us
                        your resume.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Application Modal -->
    <div id="applyModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeApplyModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title">Apply for <span
                                    id="modalJobTitle" class="text-indigo-600"></span></h3>
                            <div class="mt-4">
                                <form action="{{ route('frontend.careers.apply') }}" method="POST"
                                    enctype="multipart/form-data" id="applyForm">
                                    @csrf
                                    <input type="hidden" name="job_id" id="modalJobId">

                                    <div class="space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Full
                                                Name</label>
                                            <input type="text" name="name" id="name" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email
                                                Address</label>
                                            <input type="email" name="email" id="email" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone
                                                Number</label>
                                            <input type="text" name="phone" id="phone"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                        </div>

                                        <div>
                                            <label for="cv_file" class="block text-sm font-medium text-gray-700">Upload CV /
                                                Resume (PDF, DOC)</label>
                                            <input type="file" name="cv_file" id="cv_file" required accept=".pdf,.doc,.docx"
                                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                        </div>

                                        <div>
                                            <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover
                                                Letter (Optional)</label>
                                            <textarea name="cover_letter" id="cover_letter" rows="3"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"></textarea>
                                        </div>
                                    </div>

                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                        <button type="submit"
                                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Submit
                                            Application</button>
                                        <button type="button" onclick="closeApplyModal()"
                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openApplyModal(jobId, jobTitle) {
            document.getElementById('modalJobId').value = jobId;
            document.getElementById('modalJobTitle').innerText = jobTitle;
            document.getElementById('applyModal').classList.remove('hidden');
        }

        function closeApplyModal() {
            document.getElementById('applyModal').classList.add('hidden');
        }
    </script>
@endsection