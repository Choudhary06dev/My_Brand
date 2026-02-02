<aside class="w-64 bg-gray-900 text-white min-h-screen flex flex-col font-sans border-r border-gray-800">
    <div class="h-20 flex items-center justify-center border-b border-gray-800 px-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center w-full justify-center">
            <img src="{{ asset('assets/logo.png') }}" alt="{{ config('app.name') }}"
                class="w-full h-auto max-h-16 object-contain">
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        @if(auth()->user()->hasPermission('dashboard'))
            <!-- Dashboard Link -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
        @endif

        @if(auth()->user()->hasPermission('users'))
            <!-- Users Link -->
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Users
            </a>
        @endif

        @if(auth()->user()->hasPermission('orders') || auth()->user()->hasPermission('dashboard'))
            <!-- Orders Link -->
            <a href="{{ route('admin.orders.index') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Orders
            </a>

            <!-- Returns Link -->
            <a href="{{ route('admin.returns.index') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.returns.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                </svg>
                Returns
            </a>
        @endif

        @if(auth()->user()->hasPermission('roles'))
            <!-- Roles Link -->
            <a href="{{ route('admin.roles.index') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Roles
            </a>
        @endif



        @if(auth()->user()->hasPermission('services'))
            <!-- Services Link -->
            <a href="{{ route('admin.services.index') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                Services
            </a>
        @endif

        @if(auth()->user()->hasPermission('products') || auth()->user()->hasPermission('product_categories') || auth()->user()->hasPermission('product_gallery'))
            <!-- Products with Sub-menu -->
            <!-- Shop Management Link -->
            <div
                x-data="{ open: {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.product-categories.*') || request()->routeIs('admin.fabric-categories.*') || request()->routeIs('admin.fabrics.*') ? 'true' : 'false' }} }">
                <div class="flex items-center">
                    <a href="#" @click.prevent="open = !open"
                        class="flex-1 flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-l-lg transition-colors duration-200 {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.product-categories.*') || request()->routeIs('admin.fabric-categories.*') || request()->routeIs('admin.fabrics.*') ? 'bg-gray-800 text-white' : '' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Shop Mgmt.</span>
                    </a>
                    <button @click="open = !open"
                        class="px-3 py-3 text-white hover:bg-gray-800 rounded-r-lg transition-colors duration-200 {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.product-categories.*') || request()->routeIs('admin.fabric-categories.*') || request()->routeIs('admin.fabrics.*') ? 'bg-gray-800' : '' }}"
                        :class="{ 'bg-gray-800': open }">
                        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95" class="ml-8 mt-2 space-y-1">

                    <!-- Products Link -->
                    @if(auth()->user()->hasPermission('products'))
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Products
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('product_categories'))
                        <a href="{{ route('admin.product-categories.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.product-categories.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Product Categories
                        </a>
                        <a href="{{ route('admin.product-categories.sub-index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.product-categories.sub-index') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Subcategories
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('product_categories'))
                        <a href="{{ route('admin.fabric-categories.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.fabric-categories.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Fabric Categories
                        </a>
                        <a href="{{ route('admin.fabrics.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.fabrics.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Fabrics
                        </a>
                    @endif

                </div>
            </div>
        @endif

        @if(auth()->user()->hasPermission('blogs'))
            <!-- Blogs Link -->
            <a href="{{ route('admin.blogs.index') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.blogs.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Blogs
            </a>
        @endif

        @if(auth()->user()->hasPermission('sliders'))
            <!-- Sliders Link -->
            <a href="{{ route('admin.sliders.index') }}"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.sliders.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Sliders
            </a>
        @endif

        @if(auth()->user()->hasPermission('contact_messages') || auth()->user()->hasPermission('activity_logs') || auth()->user()->hasPermission('error_logs') || auth()->user()->hasPermission('visitors') || auth()->user()->hasPermission('clients') || auth()->user()->hasPermission('certificates') || auth()->user()->hasPermission('dashboard'))
            <!-- Pages with Sub-menu -->
            <div
                x-data="{ open: {{ request()->routeIs('admin.contact-messages.*') || request()->routeIs('admin.activity-logs.*') || request()->routeIs('admin.error-logs.*') || request()->routeIs('admin.visitors.*') || request()->routeIs('admin.pages.*') || request()->routeIs('admin.clients.*') || request()->routeIs('admin.certificates.*') ? 'true' : 'false' }} }">
                <div class="flex items-center">
                    <a href="#" @click.prevent="open = !open"
                        class="flex-1 flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-l-lg transition-colors duration-200 {{ request()->routeIs('admin.contact-messages.*') || request()->routeIs('admin.activity-logs.*') || request()->routeIs('admin.error-logs.*') || request()->routeIs('admin.visitors.*') || request()->routeIs('admin.pages.*') || request()->routeIs('admin.clients.*') || request()->routeIs('admin.certificates.*') ? 'bg-gray-800 text-white' : '' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Pages</span>
                    </a>
                    <button @click="open = !open"
                        class="px-3 py-3 text-white hover:bg-gray-800 rounded-r-lg transition-colors duration-200 {{ request()->routeIs('admin.contact-messages.*') || request()->routeIs('admin.activity-logs.*') || request()->routeIs('admin.error-logs.*') || request()->routeIs('admin.visitors.*') ? 'bg-gray-800' : '' }}"
                        :class="{ 'bg-gray-800': open }">
                        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95" class="ml-8 mt-2 space-y-1">

                    <!-- About Us Link -->
                    @if(auth()->user()->hasPermission('dashboard'))
                        <a href="{{ route('admin.pages.about') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.pages.about') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            About Us
                        </a>
                    @endif

                    <!-- Contact Messages Link -->
                    @if(auth()->user()->hasPermission('contact_messages'))
                        <a href="{{ route('admin.contact-messages.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.contact-messages.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Contact Messages
                        </a>

                    @endif

                    <!-- Activity Logs Link -->
                    @if(auth()->user()->hasPermission('activity_logs'))
                        <a href="{{ route('admin.activity-logs.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Activity Logs
                        </a>
                    @endif

                    <!-- Error Logs Link -->
                    @if(auth()->user()->hasPermission('error_logs'))
                        <a href="{{ route('admin.error-logs.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.error-logs.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Error Logs
                        </a>
                    @endif

                    <!-- Visitors Link -->
                    @if(auth()->user()->hasPermission('visitors'))
                        <a href="{{ route('admin.visitors.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.visitors.*') ? 'bg-gray-800 text-white' : '' }}">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Visitors
                        </a>
                    @endif



                </div>
            </div>
        @endif

        @if(auth()->user()->hasPermission('settings'))
            <a href="#" onclick="openSettingsModal(); return false;"
                class="flex items-center px-4 py-3 text-white hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
        @endif
    </nav>
    <!-- Activity Details Modal (same as activity logs) -->
    <div id="viewActivityModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white" id="modal-title">Activity Details</h3>
                    <button type="button" class="text-white/80 hover:text-white focus:outline-none transition-colors"
                        onclick="closeActivityModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-5 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-slate-500 mb-1">User</dt>
                            <dd class="text-sm font-semibold text-slate-900" id="modalActivityUser">--</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-slate-500 mb-1">IP Address</dt>
                            <dd class="text-sm font-mono text-slate-900 bg-slate-100 px-2 py-1 rounded inline-block"
                                id="modalActivityIP">--</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500 mb-1">Action</dt>
                            <dd class="text-sm text-slate-900" id="modalActivityAction">--</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500 mb-1">Description</dt>
                            <dd class="text-sm text-slate-900 break-words" id="modalActivityDescription">--</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500 mb-1">Time</dt>
                            <dd class="text-sm text-slate-900" id="modalActivityTime">--</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openActivityModal(activity) {
            document.getElementById('modalActivityUser').innerText = activity.user ? activity.user.name : 'System';
            document.getElementById('modalActivityIP').innerText = activity.ip_address || 'N/A';
            document.getElementById('modalActivityAction').innerText = activity.action;
            document.getElementById('modalActivityDescription').innerText = activity.description || 'No description';
            document.getElementById('modalActivityTime').innerText = new Date(activity.created_at).toLocaleString();
            document.getElementById('viewActivityModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.querySelector('#viewActivityModal .backdrop-blur-sm').addEventListener('click', closeActivityModal);
        }
        function closeActivityModal() {
            document.getElementById('viewActivityModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openSettingsModal() {
            document.getElementById('settingsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Default open profile tab
            switchSettingsTab('profile');
        }

        function closeSettingsModal() {
            document.getElementById('settingsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function switchSettingsTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.settings-tab-content').forEach(el => el.classList.add('hidden'));
            // Remove active style from all tabs
            document.querySelectorAll('.settings-tab-btn').forEach(el => {
                el.classList.remove('text-indigo-600', 'border-indigo-600', 'bg-indigo-50');
                el.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-50');
            });

            // Show selected content
            document.getElementById('settings-tab-' + tabName).classList.remove('hidden');
            // Activate selected tab
            const activeBtn = document.getElementById('btn-tab-' + tabName);
            activeBtn.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-50');
            activeBtn.classList.add('text-indigo-600', 'border-indigo-600', 'bg-indigo-50');
        }
    </script>

    <!-- Settings Modal -->
    <div id="settingsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" onclick="closeSettingsModal()">
        </div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-100">

                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        onclick="closeSettingsModal()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex border-b border-gray-200">
                    <button
                        class="settings-tab-btn flex-1 py-3 px-4 text-center text-sm font-medium border-b-2 text-indigo-600 border-indigo-600 bg-indigo-50 hover:text-indigo-800 transition-colors"
                        id="btn-tab-profile" onclick="switchSettingsTab('profile')">
                        Profile Information
                    </button>
                    <button
                        class="settings-tab-btn flex-1 py-3 px-4 text-center text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors"
                        id="btn-tab-password" onclick="switchSettingsTab('password')">
                        Change Password
                    </button>
                </div>

                <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                    <!-- Profile Tab -->
                    <div id="settings-tab-profile" class="settings-tab-content">
                        <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="update_name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="update_name" value="{{ Auth::user()->name }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5"
                                    required autofocus autocomplete="name">
                                @error('name', 'updateProfileInformation')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="update_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="update_email" value="{{ Auth::user()->email }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5"
                                    required autocomplete="username">
                                @error('email', 'updateProfileInformation')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save
                                    Changes</button>
                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-green-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg> Saved.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Password Tab -->
                    <div id="settings-tab-password" class="settings-tab-content hidden">
                        <form method="post" action="{{ route('admin.password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password"
                                    class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="update_password_current_password"
                                    autocomplete="current-password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
                                @error('current_password', 'updatePassword')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="update_password_password"
                                    class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="password" id="update_password_password"
                                    autocomplete="new-password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
                                @error('password', 'updatePassword')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="update_password_password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    id="update_password_password_confirmation" autocomplete="new-password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
                                @error('password_confirmation', 'updatePassword')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update
                                    Password</button>
                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-green-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg> Saved.
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div
                    class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-between items-center text-sm">
                    <form method="POST" action="{{ route('admin.logout') }}" id="sidebar-logout-form">
                        @csrf
                        <button type="submit"
                            class="text-red-600 font-semibold hover:text-red-800 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Log Out
                        </button>
                    </form>
                    <button type="button" class="text-gray-500 hover:text-gray-700 transition-colors"
                        onclick="closeSettingsModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
</aside>