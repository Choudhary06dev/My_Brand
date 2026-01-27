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

            <!-- Team Section -->
            @if($teamMembers->count() > 0)
                <section class="team-section" id="team">
                    <div class="container-custom">
                        <div class="section-header">
                            <h2 class="section-title">Meet Our Team</h2>
                            <p class="section-subtitle">Meet the experts behind our success</p>
                        </div>
                        <div class="team-grid">
                            @foreach($teamMembers as $member)
                                <div class="team-card team-item cursor-pointer transform hover:scale-105 transition duration-300 js-open-team-modal"
                                    style="{{ $loop->index >= 4 ? 'display: none;' : '' }}"
                                    data-name="{{ $member->name }}"
                                    data-designation="{{ $member->designation ?? $member->position }}"
                                    data-photo="{{ $member->photo ? asset('storage/' . $member->photo) : '' }}"
                                    data-bio="{{ $member->bio }}"
                                    data-facebook="{{ $member->facebook }}"
                                    data-linkedin="{{ $member->linkedin }}"
                                    data-instagram="{{ $member->instagram }}">
                                    <div class="team-image">
                                        @if($member->photo)
                                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}">
                                        @else
                                            <div class="image-placeholder team-placeholder">
                                                <span>{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="team-content">
                                        <h3 class="team-name">{{ $member->name }}</h3>
                                        <p class="team-position">{{ $member->designation ?? $member->position }}</p>
                                        @if($member->bio)
                                            <p class="team-bio">{!! strip_tags($member->bio, '<strong><b>') !!}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <style>
                                #modal-team-bio b, #modal-team-bio strong {
                                    font-weight: bold !important;
                                }
                                #modal-team-bio ul {
                                    list-style-type: disc !important;
                                    margin-left: 1.5rem !important;
                                }
                                #modal-team-bio ol {
                                    list-style-type: decimal !important;
                                    margin-left: 1.5rem !important;
                                }
                            </style>
                        </div>

                        @if($teamMembers->count() > 4)
                            <div class="text-center mt-12">
                                <button id="toggleTeamBtn"
                                    class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition duration-300 shadow-lg hover:shadow-indigo-200">
                                    Show More Team
                                </button>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const toggleBtn = document.getElementById('toggleTeamBtn');
                                    const items = document.querySelectorAll('.team-item');

                                    if (toggleBtn) {
                                        toggleBtn.addEventListener('click', function () {
                                            const isShowingAll = this.innerText === 'Show Less Team';

                                            if (isShowingAll) {
                                                items.forEach((el, index) => {
                                                    if (index >= 4) el.style.display = 'none';
                                                });
                                                this.innerText = 'Show More Team';
                                                document.querySelector('.team-section').scrollIntoView({ behavior: 'smooth' });
                                            } else {
                                                items.forEach(el => el.style.display = '');
                                                this.innerText = 'Show Less Team';
                                            }
                                        });
                                    }
                                });
                            </script>
                        @endif
                    </div>
                </section>
            @endif
        </div>
    </div>

    <!-- Team Member Modal -->
    <div id="teamModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
            style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);" onclick="closeTeamModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl">

                <div class="bg-indigo-600 px-4 py-4 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white" id="modal-team-name">Member Name</h3>
                    <button type="button" class="text-white hover:text-gray-200 focus:outline-none" onclick="closeTeamModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                    <div class="flex flex-col items-center mb-6">
                        <!-- Large Image -->
                        <div id="modal-team-image-container"
                            class="h-32 w-32 rounded-full overflow-hidden border-4 border-white shadow-lg mb-4">
                            <img id="modal-team-image" src="" alt="Team Member" class="w-full h-full object-cover hidden">
                            <div id="modal-team-placeholder"
                                class="w-full h-full bg-indigo-100 flex items-center justify-center text-4xl font-bold text-indigo-500 hidden">
                                <span id="modal-team-initials"></span>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900" id="modal-team-name-display"></h2>
                        <p class="text-indigo-600 font-medium" id="modal-team-designation"></p>

                        <!-- Social Links -->
                        <div class="flex space-x-4 mt-4" id="modal-team-socials">
                            <a id="modal-team-facebook" href="#" target="_blank" class="text-gray-400 hover:text-blue-600 hidden">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a id="modal-team-linkedin" href="#" target="_blank" class="text-gray-400 hover:text-blue-700 hidden">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                            <a id="modal-team-instagram" href="#" target="_blank" class="text-gray-400 hover:text-pink-600 hidden">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-600 text-justify">
                        <div id="modal-team-bio"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const teamGrid = document.querySelector('.team-grid');
            if (teamGrid) {
                teamGrid.addEventListener('click', function(e) {
                    const card = e.target.closest('.js-open-team-modal');
                    if (card) {
                        const name = card.getAttribute('data-name');
                        const designation = card.getAttribute('data-designation');
                        const photo = card.getAttribute('data-photo');
                        const bio = card.getAttribute('data-bio');
                        const facebook = card.getAttribute('data-facebook');
                        const linkedin = card.getAttribute('data-linkedin');
                        const instagram = card.getAttribute('data-instagram');
                        
                        openTeamModal(name, designation, photo, bio, facebook, linkedin, instagram);
                    }
                });
            }
        });

        function openTeamModal(name, designation, photo, bio, facebook, linkedin, instagram) {
            document.getElementById('modal-team-name').innerText = name;
            document.getElementById('modal-team-name-display').innerText = name;
            document.getElementById('modal-team-designation').innerText = designation;

            // Handle Photo
            const img = document.getElementById('modal-team-image');
            const placeholder = document.getElementById('modal-team-placeholder');
            const initials = document.getElementById('modal-team-initials');

            if (photo) {
                img.src = photo;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
                initials.innerText = name.charAt(0).toUpperCase();
            }

            // Handle Bio
            const modalBio = document.getElementById('modal-team-bio');
            modalBio.innerHTML = bio;

            // Handle Social Links
            const fbLink = document.getElementById('modal-team-facebook');
            if (facebook) {
                fbLink.href = facebook;
                fbLink.classList.remove('hidden');
            } else {
                fbLink.classList.add('hidden');
            }

            const liLink = document.getElementById('modal-team-linkedin');
            if (linkedin) {
                liLink.href = linkedin;
                liLink.classList.remove('hidden');
            } else {
                liLink.classList.add('hidden');
            }

            const instaLink = document.getElementById('modal-team-instagram');
            if (instagram) {
                instaLink.href = instagram;
                instaLink.classList.remove('hidden');
            } else {
                instaLink.classList.add('hidden');
            }

            document.getElementById('teamModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeTeamModal() {
            document.getElementById('teamModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
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