@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container-custom max-w-5xl mx-auto">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 text-center border-b-2 border-indigo-500 w-fit mx-auto pb-2">About Us</h1>

        <!-- Company Info Section -->
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 p-8 md:p-14 mb-16 overflow-hidden relative group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
                <div class="lg:col-span-5 flex justify-center">
                    @if($company->about_image)
                    <div class="p-3 bg-white rounded-[2rem] shadow-xl border border-gray-50 transform hover:rotate-1 transition-transform duration-500">
                        <img src="{{ \Illuminate\Support\Str::startsWith($company->about_image, ['http', 'https']) ? $company->about_image : asset('storage/' . $company->about_image) }}" alt="About Us"
                            class="rounded-[1.5rem] max-h-[400px] w-full object-cover shadow-inner">
                    </div>
                    @else
                    <div class="bg-indigo-50 rounded-[2rem] h-72 w-full flex items-center justify-center text-indigo-300 flex-col shadow-inner">
                        <i class="fas fa-building text-6xl mb-4 opacity-20"></i>
                        <span class="font-bold text-sm uppercase tracking-widest">Digital Presence</span>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-7">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-px w-8 bg-indigo-500"></div>
                        <span class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em]">Our Heritage</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight leading-tight italic">
                        {{ $company->company_name ?? config('app.name') }}
                    </h2>

                    <div class="prose max-w-none text-slate-600 leading-[1.8] font-medium text-lg">
                        @php
                        $about = $company->about ?? 'We are dedicated to providing the best solutions for our clients.';
                        $strippedAbout = strip_tags($about);
                        $shortAbout = \Illuminate\Support\Str::words($about, 110, '...');
                        @endphp

                        @if(str_word_count($strippedAbout) > 110)
                        <div class="expandable-text">
                            <div class="short-text">{!! $shortAbout !!}</div>
                            <div class="full-text hidden">{!! $about !!}</div>
                            <button class="toggle-btn inline-flex items-center mt-8 text-indigo-600 font-black hover:text-indigo-800 transition-all transform hover:translate-x-2">
                                <span class="uppercase tracking-widest text-sm">Explore Story</span>
                                <i class="fas fa-arrow-right ml-3 text-xs"></i>
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