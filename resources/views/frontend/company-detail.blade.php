@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen pb-20">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-indigo-700 to-blue-800 py-24 text-white overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" preserveAspectRatio="none" viewBox="0 0 100 100" fill="currentColor">
                    <polygon points="0,0 100,0 100,100" />
                </svg>
            </div>
            <div class="container-custom relative z-10">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div
                        class="w-32 h-32 md:w-48 md:h-48 bg-white rounded-2xl p-4 shadow-2xl flex items-center justify-center overflow-hidden">
                        @if ($targetCompany->logo)
                            <img src="{{ \Illuminate\Support\Str::startsWith($targetCompany->logo, ['http', 'https']) ? $targetCompany->logo : asset('storage/' . $targetCompany->logo) }}"
                                alt="{{ $targetCompany->company_name }}" class="max-w-full max-h-full object-contain">
                        @else
                            <div class="text-5xl font-bold text-gray-300">{{ substr($targetCompany->company_name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl md:text-6xl font-extrabold mb-4">{{ $targetCompany->company_name }}</h1>
                        @if ($targetCompany->tagline)
                            <p class="text-xl md:text-2xl text-indigo-100 font-medium max-w-2xl">
                                {{ $targetCompany->tagline }}
                            </p>
                        @endif

                        <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                            @if($targetCompany->email)
                                <div class="flex items-center bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-envelope mr-2"></i>
                                    <span class="text-sm">{{ $targetCompany->email }}</span>
                                </div>
                            @endif
                            @if($targetCompany->phone)
                                <div class="flex items-center bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-phone mr-2"></i>
                                    <span class="text-sm">{{ $targetCompany->phone }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-custom mt-20 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Row 1: Overview and Contact -->
                <!-- Overview -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 h-full">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-2 h-8 bg-indigo-600 rounded-full mr-4"></span>
                            Company Overview
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                            @php
                                $about = $targetCompany->about ?? 'Profile content coming soon.';
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

                <!-- Contact Details -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 h-full">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Contact Details</h3>
                        <div class="space-y-6">
                            @if($targetCompany->email)
                                <div class="flex items-start">
                                    <div
                                        class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 mr-4 shrink-0">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Email Address
                                        </p>
                                        <a href="mailto:{{ $targetCompany->email }}"
                                            class="text-gray-900 font-medium hover:text-indigo-600 transition-colors">{{ $targetCompany->email }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($targetCompany->phone)
                                <div class="flex items-start">
                                    <div
                                        class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 mr-4 shrink-0">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Phone Number
                                        </p>
                                        <a href="tel:{{ $targetCompany->phone }}"
                                            class="text-gray-900 font-medium hover:text-indigo-600 transition-colors">{{ $targetCompany->phone }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($targetCompany->address)
                                <div class="flex items-start">
                                    <div
                                        class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 mr-4 shrink-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Office Address
                                        </p>
                                        <p class="text-gray-900 font-medium">{{ $targetCompany->address }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Row 2: Mission, Vision, and Quick Actions -->
                <!-- Mission -->
                <div class="lg:col-span-1">
                    @if($targetCompany->mission)
                        <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-xl h-full">
                            <div
                                class="w-12 h-12 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-200">
                                <i class="fas fa-bullseye text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Our Mission</h3>
                            <div class="text-gray-600 leading-relaxed">
                                @php
                                    $mission = $targetCompany->mission;
                                    $missionWords = str_word_count(strip_tags($mission));
                                    $shortMission = \Illuminate\Support\Str::words($mission, 55, '...');
                                @endphp

                                @if(str_word_count(strip_tags($mission)) > 55)
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
                </div>

                <!-- Vision -->
                <div class="lg:col-span-1">
                    @if($targetCompany->vision)
                        <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-xl h-full">
                            <div
                                class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-blue-200">
                                <i class="fa-solid fa-eye text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Our Vision</h3>
                            <div class="text-gray-600 leading-relaxed">
                                @php
                                    $vision = $targetCompany->vision;
                                    $shortVision = \Illuminate\Support\Str::words($vision, 45, '...');
                                @endphp

                                @if(str_word_count(strip_tags($vision)) > 45)
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

                <!-- Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-indigo-900 rounded-2xl shadow-xl p-8 text-white h-full">
                        <h3 class="text-xl font-bold mb-6">Quick Actions</h3>
                        <div class="space-y-4">
                            <a href="{{ route('home') }}"
                                class="flex items-center justify-between p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-all border border-white/5 group">
                                <span>Back to Home</span>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('frontend.contact') }}"
                                class="flex items-center justify-between p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-all border border-white/5 group">
                                <span>Get in Touch</span>
                                <i class="fas fa-paper-plane transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Section (Full Width) -->
            @if($targetCompany->history)
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 mt-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                        <span class="w-1.5 h-7 bg-indigo-600 rounded-full mr-4"></span>
                        Our Journey & History
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                        {!! $targetCompany->history !!}
                    </div>
                </div>
            @endif
        </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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