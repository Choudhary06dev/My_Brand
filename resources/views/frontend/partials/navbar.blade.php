<header class="topnav" id="topnav">
  <div class="container-custom">
    <div class="navbar-wrapper">
      <!-- Left: Logo -->
      <div class="navbar-left">
        <a href="{{ route('home') }}">
          @if(isset($company) && $company->logo)
            <img src="{{ asset('assets/logo.png') }}" class="logo-img"
              alt="{{ $company->company_name ?? config('app.name') }}">
          @elseif(file_exists(public_path('assets/logo.jpg')))
            <img src="{{ asset('assets/logo.png') }}" class="logo-img" alt="{{ config('app.name') }}">
          @else
            <div class="logo-img" style="font-size: 1.5rem; font-weight: 800; color: var(--accent-1);">{{ strtoupper(config('app.name')) }}</div>
          @endif
        </a>
      </div>

      <!-- Center: Navigation Links -->
      <div class="navbar-links" id="navbarLinks">
        <nav class="flex items-center gap-1">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
          <a class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}"
            href="{{ route('frontend.about') }}">About</a>

          <div class="nav-item-dropdown">
            <a class="nav-link {{ request()->routeIs('frontend.products') ? 'active' : '' }}"
              href="{{ route('frontend.products') }}" onclick="handleDropdownClick(event)">
              Products <i class="fas fa-chevron-down ml-2 text-[10px] opacity-50"></i>
            </a>
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

          <!-- Sale Dropdown -->
          <div class="nav-item-dropdown">
            <a class="nav-link {{ request()->routeIs('frontend.sale') ? 'active' : '' }}"
              href="{{ route('frontend.sale') }}" onclick="handleDropdownClick(event)">
              Sale <i class="fas fa-chevron-down ml-2 text-[10px] opacity-50"></i>
            </a>
            <div class="dropdown-content">
              @if(isset($saleCategories) && $saleCategories->count() > 0)
                @foreach($saleCategories as $saleCat)
                  <a href="{{ route('frontend.sale', $saleCat->slug) }}">{{ $saleCat->category_name }}</a>
                @endforeach
              @else
                <a href="#" class="text-gray-400 pointer-events-none">No Sale Items</a>
              @endif
            </div>
          </div>

          <a class="nav-link {{ request()->routeIs('frontend.services') ? 'active' : '' }}"
            href="{{ route('frontend.services') }}">Services</a>
          <a class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}"
            href="{{ route('frontend.contact') }}">Contact</a>
        </nav>
      </div>

      <!-- Right: Cart & User Dropdown -->
      <div class="navbar-right">
        <a class="icon-link relative" href="{{ route('frontend.cart') }}" title="Shopping Cart">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
          </svg>
          <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center cart-count-badge" style="display: none;">0</span>
        </a>

        <!-- User Dropdown -->
        <div class="relative">
          <button class="icon-link" title="Account" onclick="toggleUserDropdown(event)" id="userMenuButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </button>

          <!-- User Dropdown Menu -->
          <div id="userDropdown"
            class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl opacity-0 invisible transition-all duration-300 transform translate-y-2 z-50 p-2 border border-gray-100">
            @auth
                <form method="POST" action="{{ route('frontend.logout') }}" id="logout-form">
                    @csrf
                    <button type="submit"
                      class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors rounded-lg">
                      <i class="fas fa-sign-out-alt mr-3 opacity-70"></i> Logout
                    </button>
                </form>
            @else
              <a href="{{ route('frontend.login') }}"
                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors rounded-lg">
                <i class="fas fa-sign-in-alt mr-3 opacity-70"></i> Login
              </a>
              <a href="{{ route('frontend.register') }}"
                class="flex items-center px-4 py-3 text-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-lg mt-1">
                <i class="fas fa-user-plus mr-3 opacity-90"></i> Register
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
    // Scroll Header Background
    window.addEventListener('scroll', function() {
      const header = document.getElementById('topnav');
      if (window.scrollY > 20) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });

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
      const isVisible = !dropdown.classList.contains('invisible');
      
      // Close all other dropdowns if any
      
      if (isVisible) {
        dropdown.classList.add('opacity-0', 'invisible', 'translate-y-2');
      } else {
        dropdown.classList.remove('opacity-0', 'invisible', 'translate-y-2');
      }
    }

    document.addEventListener('click', function (event) {
      const links = document.getElementById('navbarLinks');
      const mobileBtn = document.querySelector('.mobile-menu-btn');
      const dropdown = document.getElementById('userDropdown');
      const button = document.getElementById('userMenuButton');

      // Close mobile menu when clicking outside
      if (links && links.classList.contains('active') && !links.contains(event.target) && !mobileBtn.contains(event.target)) {
        toggleMobileMenu();
      }

      // Close user dropdown when clicking outside
      if (dropdown && !dropdown.classList.contains('invisible') && !button.contains(event.target)) {
        dropdown.classList.add('opacity-0', 'invisible', 'translate-y-2');
      }
    });
    // Cart Count
    function updateCartCount() {
        fetch("{{ route('frontend.cart.count') }}")
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.cart-count-badge');
                if (badge) {
                    badge.innerText = data.count;
                    if (data.count > 0) {
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
    }
    document.addEventListener('DOMContentLoaded', updateCartCount);
  </script>
</header>
</header>