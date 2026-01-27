<header class="topnav">
  <div class="container">
    <div class="navbar-wrapper">
      <!-- Left: Logo -->
      <div class="navbar-left">
        <a href="{{ route('home') }}">
          @if(isset($company) && $company->logo)
            <img src="{{ asset('assets/logo.jpg') }}" class="logo-img"
              alt="{{ $company->company_name ?? 'AOHT' }}">
          @elseif(file_exists(public_path('assets/logo.jpg')))
            <img src="{{ asset('assets/logo.jpg') }}" class="logo-img" alt="AOHT Group">
          @else
            <div class="logo-img" style="font-size: 1.5rem; font-weight: 800; color: var(--accent-1);">AOHT GROUP</div>
          @endif
        </a>
      </div>

      <!-- Center: Navigation Links -->
      <div class="navbar-links" id="navbarLinks">
        <nav class="flex items-center gap-2 text-sm">

          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
          <a class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}"
            href="{{ route('frontend.about') }}">About</a>
          <a class="nav-link {{ request()->routeIs('frontend.company.show') ? 'active' : '' }}"
            href="{{ route('frontend.company.show') }}">Companies</a>


          <div class="nav-item-dropdown">
            <a class="nav-link {{ request()->routeIs('frontend.products') ? 'active' : '' }}"
              href="{{ route('frontend.products') }}" onclick="handleDropdownClick(event)">Products</a>
            <div class="dropdown-content">
              @if(isset($mainCategories))
                @foreach($mainCategories as $cat)
                  @if($cat->children->count() > 0)
                    <div class="dropdown-submenu">
                      <a href="{{ route('frontend.category.detail', $cat->slug) }}"
                        class="has-submenu">{{ $cat->category_name }}</a>
                      <div class="submenu-content">
                        @foreach($cat->children as $sub)
                          @if($sub->children->count() > 0)
                            <div class="dropdown-submenu">
                              <a href="{{ route('frontend.category.detail', $sub->slug) }}"
                                class="has-submenu">{{ $sub->category_name }}</a>
                              <div class="submenu-content">
                                @foreach($sub->children as $child)
                                  <a href="{{ route('frontend.category.detail', $child->slug) }}">{{ $child->category_name }}</a>
                                @endforeach
                              </div>
                            </div>
                          @else
                            <a href="{{ route('frontend.category.detail', $sub->slug) }}">{{ $sub->category_name }}</a>
                          @endif
                        @endforeach
                      </div>
                    </div>
                  @else
                    <a href="{{ route('frontend.category.detail', $cat->slug) }}">{{ $cat->category_name }}</a>
                  @endif
                @endforeach
              @endif
            </div>
          </div>


          <a class="nav-link {{ request()->routeIs('frontend.services') ? 'active' : '' }}"
            href="{{ route('frontend.services') }}">Services</a>
          <a class="nav-link {{ request()->routeIs('frontend.careers') ? 'active' : '' }}"
            href="{{ route('frontend.careers') }}">Careers</a>
          <a class="nav-link {{ request()->routeIs('frontend.news') || request()->routeIs('frontend.news.detail') ? 'active' : '' }}"
            href="{{ route('frontend.news') }}">News</a>
          <a class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}"
            href="{{ route('frontend.contact') }}">Contact Us</a>
        </nav>
      </div>

      <!-- Right: Cart & User Dropdown -->
      <div class="navbar-right">
        <a class="icon-link" href="#" title="Shopping Cart">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
          </svg>
        </a>

        <!-- User Dropdown -->
        <div class="relative">
          <button class="icon-link flex items-center" title="Account" onclick="toggleUserDropdown(event)"
            id="userMenuButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <!-- Dropdown Menu -->
          <div id="userDropdown"
            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible transition-all duration-200 z-50">
            @auth
                {{-- Dashboard link removed as per request --}}
                <form method="POST" action="{{ route('frontend.logout') }}" id="logout-form">
                    @csrf
                    <button type="submit"
                      class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors rounded-lg">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                      </svg>
                      Logout
                    </button>
                </form>
            @else
              <a href="{{ route('frontend.login') }}"
                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors rounded-t-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                  <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                  <polyline points="10 17 15 12 10 7"></polyline>
                  <line x1="15" y1="12" x2="3" y2="12"></line>
                </svg>
                Login
              </a>
              <a href="{{ route('frontend.register') }}"
                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors rounded-b-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="8.5" cy="7" r="4"></circle>
                  <line x1="20" y1="8" x2="20" y2="14"></line>
                  <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                Register
              </a>
            @endauth
          </div>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>
  </div>
  <script>
    function toggleMobileMenu() {
      const links = document.getElementById('navbarLinks');
      links.classList.toggle('active');
      const icon = document.querySelector('.mobile-menu-btn i');
      if (links.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
      } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
    }

    function handleDropdownClick(event) {
      if (window.innerWidth <= 1024) {
        event.preventDefault();
        const parent = event.target.closest('.nav-item-dropdown');
        parent.classList.toggle('active');
      }
    }

    function toggleUserDropdown(event) {
      event.stopPropagation();
      const dropdown = document.getElementById('userDropdown');
      dropdown.classList.toggle('opacity-0');
      dropdown.classList.toggle('invisible');
    }

    document.addEventListener('click', function (event) {
      const links = document.getElementById('navbarLinks');
      const mobileBtn = document.querySelector('.mobile-menu-btn');

      // Close mobile menu when clicking outside
      if (links.classList.contains('active') && !links.contains(event.target) && !mobileBtn.contains(event.target)) {
        toggleMobileMenu();
      }

      const dropdown = document.getElementById('userDropdown');
      const button = document.getElementById('userMenuButton');
      if (dropdown && !dropdown.classList.contains('invisible') && !button.contains(event.target)) {
        dropdown.classList.add('opacity-0');
        dropdown.classList.add('invisible');
      }
    });
  </script>
</header>