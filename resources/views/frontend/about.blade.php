@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container-custom max-w-5xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8 text-center border-b-2 border-indigo-500 w-fit mx-auto pb-2">About Us</h1>

            <!-- Company Info Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-10 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-10 items-center">
                    <div class="md:col-span-2 flex justify-center">
                        @if($company->about_image)
                            <div class="p-2 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                                <img src="{{ \Illuminate\Support\Str::startsWith($company->about_image, ['http', 'https']) ? $company->about_image : asset('storage/' . $company->about_image) }}" alt="About Us"
                                    class="rounded-lg max-h-[350px] w-auto object-contain">
                            </div>
                        @else
                            <div class="bg-gray-200 rounded-lg h-64 w-full flex items-center justify-center text-gray-500 flex-col">
                                <span>No Image Uploaded</span>
                            </div>
                        @endif
                    </div>
                    <div class="md:col-span-3">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $company->company_name ?? config('app.name') }}</h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed text-sm md:text-base">
                            @php
                                $about = $company->about ?? 'We are dedicated to providing the best solutions for our clients.';
                                $strippedAbout = strip_tags($about);
                                $shortAbout = \Illuminate\Support\Str::words($about, 135, '...');
                            @endphp

                            @if(str_word_count($strippedAbout) > 135)
                                <div class="expandable-text">
                                    <div class="short-text">{!! $shortAbout !!}</div>
                                    <div class="full-text hidden">{!! $about !!}</div>
                                    <button class="toggle-btn text-indigo-600 font-bold hover:text-indigo-800 transition-colors mt-4 flex items-center">
                                        <span>Read More</span>
                                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                    </button>
                                </div>
                            @else
                                {!! $about !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mission & Vision Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                @if($company->mission)
                    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-indigo-500">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 border-b-2 border-indigo-500 w-fit pb-1">Our Mission</h3>
                        <div class="text-gray-600 leading-relaxed">
                            @php
                                $mission = $company->mission;
                                $strippedMission = strip_tags($mission);
                                $shortMission = \Illuminate\Support\Str::words($mission, 55, '...');
                            @endphp

                            @if(str_word_count($strippedMission) > 55)
                                <div class="expandable-text">
                                    <div class="short-text">{!! $shortMission !!}</div>
                                    <div class="full-text hidden">{!! $mission !!}</div>
                                    <button class="toggle-btn text-indigo-600 font-bold hover:text-indigo-800 transition-colors mt-2 flex items-center">
                                        <span>Read More</span>
                                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                    </button>
                                </div>
                            @else
                                {!! $mission !!}
                            @endif
                        </div>
                    </div>
                @endif
                @if($company->vision)
                    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-indigo-500">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 border-b-2 border-indigo-500 w-fit pb-1">Our Vision</h3>
                        <div class="text-gray-600 leading-relaxed">
                            @php
                                $vision = $company->vision;
                                $strippedVision = strip_tags($vision);
                                $shortVision = \Illuminate\Support\Str::words($vision, 45, '...');
                            @endphp

                            @if(str_word_count($strippedVision) > 45)
                                <div class="expandable-text">
                                    <div class="short-text">{!! $shortVision !!}</div>
                                    <div class="full-text hidden">{!! $vision !!}</div>
                                    <button class="toggle-btn text-indigo-600 font-bold hover:text-indigo-800 transition-colors mt-2 flex items-center">
                                        <span>Read More</span>
                                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                    </button>
                                </div>
                            @else
                                {!! $vision !!}
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- History Section (Full Width) -->
            @if($company->history)
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-indigo-600 mb-20">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Our Journey & History</h3>
                    <div class="text-gray-600 leading-relaxed">{!! $company->history !!}</div>
                </div>
            @endif

            <!-- Contact Information Section -->
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-indigo-600 mb-20">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 border-b-2 border-indigo-500 w-fit pb-2">Contact Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Company Details -->
                    <div class="space-y-6">
                        @if($company->company_name)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Company Name</h3>
                                <p class="text-lg font-bold text-gray-900">{{ $company->company_name }}</p>
                            </div>
                        @endif

                        @if($company->address)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Address</h3>
                                <p class="text-gray-700">{{ $company->address }}</p>
                            </div>
                        @endif

                        @if($company->city || $company->country)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Location</h3>
                                <p class="text-gray-700">
                                    @if($company->city){{ $company->city }}@endif
                                    @if($company->city && $company->country){{ ', ' }}@endif
                                    @if($company->country){{ $company->country }}@endif
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Contact Details -->
                    <div class="space-y-6">
                        @if($company->email)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Email</h3>
                                <a href="mailto:{{ $company->email }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                                    {{ $company->email }}
                                </a>
                            </div>
                        @endif

                        @if($company->phone)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Phone</h3>
                                <a href="tel:{{ $company->phone }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                                    {{ $company->phone }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared toggle logic for Read More/Less
        const toggleButtons = document.querySelectorAll('.toggle-btn');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const container = this.closest('.expandable-text');
                const shortText = container.querySelector('.short-text');
                const fullText = container.querySelector('.full-text');
                const isExpanded = !fullText.classList.contains('hidden');
                
                if (isExpanded) {
                    // Show Less
                    fullText.classList.add('hidden');
                    shortText.classList.remove('hidden');
                    this.querySelector('span').textContent = 'Read More';
                    this.querySelector('i').classList.replace('fa-chevron-up', 'fa-chevron-down');
                } else {
                    // Read More
                    fullText.classList.remove('hidden');
                    shortText.classList.add('hidden');
                    this.querySelector('span').textContent = 'Show Less';
                    this.querySelector('i').classList.replace('fa-chevron-down', 'fa-chevron-up');
                }
            });
        });
    });
</script>
@endpush