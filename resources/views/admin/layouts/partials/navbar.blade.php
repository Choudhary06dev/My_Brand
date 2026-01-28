<header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 z-10">
    <!-- Left side: Search or Breadcrumbs -->
    <div class="flex items-center">
        <button class="text-gray-500 focus:outline-none lg:hidden mr-4">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="relative">
             <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" class="pl-10 pr-4 py-2 border-none rounded-lg bg-gray-100 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 w-64 transition-all" placeholder="Search...">
        </div>
    </div>

    <!-- Right side: User Profile -->
    <div class="flex items-center space-x-4">
        <!-- Notification Icon -->
        <button class="text-gray-400 hover:text-gray-600 focus:outline-none relative">
             <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500 border-2 border-white"></span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800 focus:outline-none">
                <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold mr-2">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <span>{{ Auth::user()->name ?? 'User' }}</span>
                <svg class="h-4 w-4 ml-1 fill-current text-gray-500" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50" 
                 style="display: none;">
                <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
