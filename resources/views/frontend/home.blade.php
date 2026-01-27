@extends('frontend.layouts.app')

@section('content')

  <!-- HERO SLIDER -->
  <section class="hero-slider">
    <div class="slides" id="slides">
      @if(!empty($sliders) && $sliders->count())
        @foreach($sliders as $slide)
          <div class="slide"
            style="background-image: url('{{ $slide->image ? asset('storage/' . $slide->image) : '' }}'); background-size:cover; background-position:center;">
            <div class="overlay"></div>
            <div class="slide-content">
              <h2 class="title">{{ $slide->title ?? config('app.name') }}</h2>
              <p class="subtitle">{{ $slide->subtitle ?? '' }}</p>
              @if(!empty($slide->button_text))
                <a class="btn btn-light mt-4" href="{{ $slide->button_link ?: '#' }}">{{ $slide->button_text }}</a>
              @endif
            </div>
          </div>
        @endforeach
      @else
        <!-- Slide 1 -->
        <div class="slide"
          style="background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('{{ asset('assets/slider1.png') }}'); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="slide-content">
            <h2 class="title">Welcome to {{ config('app.name') }}</h2>
            <p class="subtitle">Integrated business solutions across Hospitality, Technology, Real Estate, HR, and
              Consultancy</p>
            <a class="btn btn-light mt-4" href="#">Learn More</a>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide"
          style="background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('{{ asset('assets/slider2.png') }}'); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="slide-content">
            <h2 class="title">Innovation & Excellence</h2>
            <p class="subtitle">Delivering cutting-edge solutions with over a decade of industry expertise and commitment to
              quality</p>
            <a class="btn btn-light mt-4" href="#">Our Services</a>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide"
          style="background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('{{ asset('assets/slider3.png') }}'); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="slide-content">
            <h2 class="title">Transforming Businesses</h2>
            <p class="subtitle">Empowering organizations with comprehensive technology, hospitality, and consultancy
              solutions</p>
            <a class="btn btn-light mt-4" href="#">Contact Us</a>
          </div>
        </div>
      @endif
    </div>

    @if(($sliders && $sliders->count() > 1) || (!$sliders || $sliders->count() == 0))
      <div id="prev" class="slider-arrow arrow-left">❮</div>
      <div id="next" class="slider-arrow arrow-right">❯</div>

      <div class="dots" id="dots">
        @if($sliders && $sliders->count() > 0)
          @foreach($sliders as $index => $slide)
            <div class="dot {{ $index == 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
          @endforeach
        @else
          <div class="dot active" data-index="0"></div>
          <div class="dot" data-index="1"></div>
          <div class="dot" data-index="2"></div>
        @endif
      </div>
    @endif
  </section>

  <!-- CATEGORIES/SALE SECTION -->
  <section class="categories-section">
    <div class="container-custom">
      <div class="section-header">
        <h2 class="section-title">Shop by Category</h2>
        <p class="section-subtitle">Discover our curated collection of premium beach essentials</p>
      </div>
      <div class="categories-grid">
        @if(isset($categories) && $categories->count() > 0)
          <!-- Column 1: Item 1 -->
          @if(isset($categories[0]))
            <div class="category-column">
              <a href="{{ route('frontend.category.detail', $categories[0]->slug) }}"
                class="category-card category-auto block">
                <div class="category-image">
                  @if($categories[0]->image)
                    <img src="{{ asset('storage/' . $categories[0]->image) }}" alt="{{ $categories[0]->category_name }}">
                  @else
                    <div class="image-placeholder"><span>{{ substr($categories[0]->category_name, 0, 1) }}</span></div>
                  @endif
                </div>
                <div class="category-label">{{ $categories[0]->category_name }}</div>
              </a>
            </div>
          @endif

          <!-- Column 2: Item 2 & 3 -->
          @if(isset($categories[1]) || isset($categories[2]))
            <div class="category-column">
              @if(isset($categories[1]))
                <a href="{{ route('frontend.category.detail', $categories[1]->slug) }}"
                  class="category-card category-half block">
                  <div class="category-image">
                    @if($categories[1]->image)
                      <img src="{{ asset('storage/' . $categories[1]->image) }}" alt="{{ $categories[1]->category_name }}">
                    @else
                      <div class="image-placeholder"><span>{{ substr($categories[1]->category_name, 0, 1) }}</span></div>
                    @endif
                  </div>
                  <div class="category-label">{{ $categories[1]->category_name }}</div>
                </a>
              @endif
              @if(isset($categories[2]))
                <a href="{{ route('frontend.category.detail', $categories[2]->slug) }}"
                  class="category-card category-half block">
                  <div class="category-image">
                    @if($categories[2]->image)
                      <img src="{{ asset('storage/' . $categories[2]->image) }}" alt="{{ $categories[2]->category_name }}">
                    @else
                      <div class="image-placeholder"><span>{{ substr($categories[2]->category_name, 0, 1) }}</span></div>
                    @endif
                  </div>
                  <div class="category-label">{{ $categories[2]->category_name }}</div>
                </a>
              @endif
            </div>
          @endif

          <!-- Column 3: Item 4 (Center Large) -->
          @if(isset($categories[3]))
            <div class="category-column">
              <a href="{{ route('frontend.category.detail', $categories[3]->slug) }}"
                class="category-card category-full block">
                <div class="category-image">
                  @if($categories[3]->image)
                    <img src="{{ asset('storage/' . $categories[3]->image) }}" alt="{{ $categories[3]->category_name }}">
                  @else
                    <div class="image-placeholder"><span>{{ substr($categories[3]->category_name, 0, 1) }}</span></div>
                  @endif
                </div>
                <div class="category-label">{{ $categories[3]->category_name }}</div>
              </a>
            </div>
          @endif

          <!-- Column 4: Item 5 & 6 -->
          @if(isset($categories[4]) || isset($categories[5]))
            <div class="category-column">
              @if(isset($categories[4]))
                <a href="{{ route('frontend.category.detail', $categories[4]->slug) }}"
                  class="category-card category-half block">
                  <div class="category-image">
                    @if($categories[4]->image)
                      <img src="{{ asset('storage/' . $categories[4]->image) }}" alt="{{ $categories[4]->category_name }}">
                    @else
                      <div class="image-placeholder"><span>{{ substr($categories[4]->category_name, 0, 1) }}</span></div>
                    @endif
                  </div>
                  <div class="category-label">{{ $categories[4]->category_name }}</div>
                </a>
              @endif
              @if(isset($categories[5]))
                <a href="{{ route('frontend.category.detail', $categories[5]->slug) }}"
                  class="category-card category-half block">
                  <div class="category-image">
                    @if($categories[5]->image)
                      <img src="{{ asset('storage/' . $categories[5]->image) }}" alt="{{ $categories[5]->category_name }}">
                    @else
                      <div class="image-placeholder"><span>{{ substr($categories[5]->category_name, 0, 1) }}</span></div>
                    @endif
                  </div>
                  <div class="category-label">{{ $categories[5]->category_name }}</div>
                </a>
              @endif
            </div>
          @endif

          <!-- Column 5: Item 7 -->
          @if(isset($categories[6]))
            <div class="category-column">
              <a href="{{ route('frontend.category.detail', $categories[6]->slug) }}"
                class="category-card category-auto block">
                <div class="category-image">
                  @if($categories[6]->image)
                    <img src="{{ asset('storage/' . $categories[6]->image) }}" alt="{{ $categories[6]->category_name }}">
                  @else
                    <div class="image-placeholder"><span>{{ substr($categories[6]->category_name, 0, 1) }}</span></div>
                  @endif
                </div>
                <div class="category-label">{{ $categories[6]->category_name }}</div>
              </a>
            </div>
          @endif
        @else
          <!-- Fallback to static if no categories found (Optional: remove this else block if you want it empty) -->
          <div class="col-span-full text-center py-10 text-gray-400">No categories available.</div>
        @endif
      </div>

      @if(isset($totalCategories) && $totalCategories > 7)
        <div class="flex justify-center mt-12">
          <a href="{{ route('frontend.categories') }}"
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
            Show More
            <svg class="ml-2 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </a>
        </div>
      @endif
    </div>
  </section>


  <!-- FEATURED PROJECTS -->
  @if(!empty($products) && $products->count())
    <section class="projects-section">
      <div class="container-custom">
        <div class="section-header">
          <h2 class="section-title">Products</h2>
          <p class="section-subtitle">Exquisite essentials for your sun-drenched lifestyle</p>
        </div>
        <div class="projects-grid">
          @foreach($products as $index => $product)
            <div class="project-card product-item" style="{{ $index >= 4 ? 'display: none;' : '' }}">
              <div class="project-image">
                @if($product->discount_price)
                  <div class="sale-badge">Sale</div>
                @endif
                
                <a href="{{ route('frontend.products.detail', $product->slug) }}" class="block w-full h-full">
                  @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}">
                  @else
                    <div class="image-placeholder">
                      <span>📦</span>
                    </div>
                  @endif
                  
                  <div class="quick-view-overlay">
                    <button class="quick-view-btn">Discover</button>
                  </div>
                </a>
              </div>
              
              <div class="project-content">
                <h3 class="project-title">{{ $product->product_name }}</h3>
                <div class="flex-price">
                  @if($product->discount_price)
                    <span class="price-new">PKR {{ number_format($product->discount_price) }}</span>
                    <span class="price-old">PKR {{ number_format($product->price) }}</span>
                  @elseif($product->price)
                    <span class="price-new">PKR {{ number_format($product->price) }}</span>
                  @endif
                </div>
                <p class="project-description">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 100) }}</p>
                <a href="{{ route('frontend.products.detail', $product->slug) }}" class="shop-now-link">Shop Now</a>
              </div>
            </div>
          @endforeach
        </div>

        @if($products->count() > 4)
          <div class="text-center mt-8">
            <button id="toggleProductsBtn"
              class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition duration-150 ease-in-out">
              Show More
            </button>
          </div>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const toggleBtn = document.getElementById('toggleProductsBtn');
              const products = document.querySelectorAll('.product-item');

              if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                  const isShowingAll = this.innerText === 'Show Less';

                  if (isShowingAll) {
                    // Hide products > 4
                    products.forEach((el, index) => {
                      if (index >= 4) el.style.display = 'none';
                    });
                    this.innerText = 'Show More';

                    // Scroll back to projects section
                    document.querySelector('.projects-section').scrollIntoView({ behavior: 'smooth' });
                  } else {
                    // Show all products
                    products.forEach(el => el.style.display = 'block'); // assuming default display is block or compatible with grid
                    // If grid container uses default flow for items, removing 'none' usually works. 
                    // But specifically for grid items, 'display: block' might break layout if not careful? 
                    // Actually, 'display: unset' or just empty string is safer for "reverting to css".
                    products.forEach(el => el.style.display = '');
                    this.innerText = 'Show Less';
                  }
                });
              }
            });
          </script>
        @endif
      </div>
    </section>
  @endif

  <!-- SERVICES SECTION -->
  @if(!empty($services) && $services->count())
    <section class="services-section">
      <div class="container-custom">
        <div class="section-header">
          <h2 class="section-title">Our Services</h2>
          <p class="section-subtitle">Comprehensive solutions tailored to your business needs</p>
        </div>
        <div class="services-grid">
          @foreach($services as $service)
            <div class="service-card service-item hover:shadow-xl transition-all duration-300"
              style="padding: 0; {{ $loop->index >= 4 ? 'display: none;' : '' }}">
              <a href="{{ route('frontend.services.detail', $service->slug) }}" class="block h-full">
                @if($service->banner_image)
                  <div class="h-40 w-full overflow-hidden rounded-t-2xl">
                    @if(\Illuminate\Support\Str::startsWith($service->banner_image, ['http://', 'https://']))
                      <img src="{{ $service->banner_image }}" alt="{{ $service->service_name }}"
                        class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                    @else
                      <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->service_name }}"
                        class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                    @endif
                  </div>
                @endif

                <div class="p-8">
                  <div class="service-icon">
                    @if($service->icon)
                      @if(\Illuminate\Support\Str::contains($service->icon, ['http://', 'https://']) || \Illuminate\Support\Str::contains($service->icon, ['.jpg', '.png', '.jpeg', '.svg', '.webp']))
                        @if(\Illuminate\Support\Str::startsWith($service->icon, ['http://', 'https://']))
                          <img src="{{ $service->icon }}" alt="{{ $service->service_name }}">
                        @else
                          <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->service_name }}">
                        @endif
                      @else
                        <!-- Assume FontAwesome Class -->
                        <i class="{{ $service->icon }}" style="font-size: 2rem; color: white;"></i>
                      @endif
                    @else
                      <div class="icon-placeholder">{{ strtoupper(substr($service->service_name, 0, 1)) }}</div>
                    @endif
                  </div>
                  <h3 class="service-title">{{ $service->service_name }}</h3>
                  <span class="service-link">Learn More →</span>
                </div>
              </a>
            </div>
          @endforeach
        </div>

        @if($services->count() > 4)
          <div class="text-center mt-12">
            <button id="toggleServicesBtn"
              class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition duration-300 shadow-lg hover:shadow-indigo-200">
              Show More Services
            </button>
          </div>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const toggleBtn = document.getElementById('toggleServicesBtn');
              const items = document.querySelectorAll('.service-item');

              if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                  const isShowingAll = this.innerText === 'Show Less Services';

                  if (isShowingAll) {
                    items.forEach((el, index) => {
                      if (index >= 4) el.style.display = 'none';
                    });
                    this.innerText = 'Show More Services';
                    document.querySelector('.services-section').scrollIntoView({ behavior: 'smooth' });
                  } else {
                    items.forEach(el => el.style.display = '');
                    this.innerText = 'Show Less Services';
                  }
                });
              }
            });
          </script>
        @endif
      </div>
    </section>
  @endif


  <!-- STATISTICS SECTION -->
  <!-- <section class="stats-section">
                        <div class="container-custom">
                          <div class="stats-grid">
                            <div class="stat-card">
                              <div class="stat-number">5000+</div>
                              <div class="stat-label">Textile Products</div>
                            </div>
                            <div class="stat-card">
                              <div class="stat-number">100+</div>
                              <div class="stat-label">Global Partners</div>
                            </div>
                            <div class="stat-card">
                              <div class="stat-number">50+</div>
                              <div class="stat-label">Countries Served</div>
                            </div>
                            <div class="stat-card">
                              <div class="stat-number">10M+</div>
                              <div class="stat-label">Garments Delivered</div>
                            </div>
                          </div>
                        </div>
                      </section> -->

  <!-- TEAM MEMBERS SECTION -->
  @if(!empty($teamMembers) && $teamMembers->count())
    <section class="team-section">
      <div class="container-custom">
        <div class="section-header">
          <h2 class="section-title">Our Team</h2>
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

  <!-- LATEST BLOGS -->
  @if(!empty($blogs) && $blogs->count())
    <section class="blogs-section">
      <div class="container-custom">
        <div class="section-header">
          <h2 class="section-title">Latest News & Insights</h2>
          <p class="section-subtitle">Stay updated with our latest news and industry insights</p>
        </div>
        <div class="blogs-grid">
          @foreach($blogs as $blog)
            <div class="blog-card">
              <div class="blog-image">
                @if($blog->thumbnail)
                  <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}">
                @else
                  <div class="image-placeholder">
                    <span>📰</span>
                  </div>
                @endif
              </div>
              <div class="blog-content">
                <h3 class="blog-title">{{ $blog->title }}</h3>
                <a href="{{ route('frontend.news.detail', $blog->id) }}" class="blog-link">Read More →</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif



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