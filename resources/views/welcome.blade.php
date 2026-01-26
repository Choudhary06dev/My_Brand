<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Brand | Premium Essentials</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white font-sans antialiased text-gray-900 selection:bg-indigo-100 selection:text-indigo-900">
    
    <!-- Top Global Banner -->
    <div class="bg-[#1b1b18] text-white text-[10px] font-black uppercase tracking-[0.2em] py-3 text-center">
        Welcome to the future of retail &bull; 15% off your first order
    </div>

    <!-- Main Navigation (Minimalist) -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-black tracking-tighter uppercase italic">MY BRAND</a>
                </div>
                <div class="hidden lg:flex space-x-12">
                    <a href="#" class="text-[11px] font-bold uppercase tracking-widest text-gray-500 hover:text-black transition-colors">Collections</a>
                    <a href="#" class="text-[11px] font-bold uppercase tracking-widest text-gray-500 hover:text-black transition-colors">New Arrivals</a>
                    <a href="#" class="text-[11px] font-bold uppercase tracking-widest text-gray-500 hover:text-black transition-colors">Journal</a>
                </div>
                <div class="flex items-center gap-6">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-[11px] font-bold uppercase tracking-widest text-indigo-600">Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[11px] font-bold uppercase tracking-widest text-gray-500 hover:text-black transition-colors">Sign In</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Banners) -->
    <section class="relative overflow-hidden" x-data="{ activeBanner: 0, totalBanners: {{ $banners->count() }} }">
        <div class="relative h-[85vh] min-h-[600px] w-full">
            @forelse($banners as $index => $banner)
                <div x-show="activeBanner === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 w-full h-full">
                    
                    <!-- Background Visual -->
                    <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover">
                    
                    <!-- Content Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/20 to-transparent p-12 lg:p-24 flex flex-col justify-center">
                        <div class="max-w-2xl space-y-6">
                            @if($banner->title)
                                <h1 class="text-5xl lg:text-8xl font-black text-white leading-tight tracking-[0.02em] uppercase">
                                    {{ $banner->title }}
                                </h1>
                            @endif
                            
                            @if($banner->subtitle)
                                <p class="text-lg lg:text-xl text-white/80 font-medium leading-relaxed">
                                    {{ $banner->subtitle }}
                                </p>
                            @endif

                            <div class="pt-8">
                                <a href="{{ $banner->link ?? '#' }}" class="inline-flex items-center px-12 py-5 bg-white text-black rounded-full font-black uppercase tracking-[0.2em] text-[11px] shadow-2xl hover:bg-black hover:text-white transition-all transform hover:-translate-y-1 active:scale-95">
                                    {{ $banner->button_text ?? 'Shop Collection' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Default Placeholder Hero -->
                <div class="w-full h-full bg-gray-50 flex items-center justify-center p-12 text-center">
                    <div class="max-w-xl space-y-6">
                        <h1 class="text-6xl lg:text-8xl font-black text-gray-900 leading-tight tracking-tighter uppercase italic">
                            Elevated Essentials
                        </h1>
                        <p class="text-xl text-gray-500 font-medium">Design your storefront today from the admin dashboard.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-12 py-5 bg-black text-white rounded-full font-black uppercase tracking-[0.2em] text-[11px]">
                            Get Started
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Carousel Indicators -->
        @if($banners->count() > 1)
            <div class="absolute bottom-12 left-12 lg:left-24 flex gap-4 z-20">
                @foreach($banners as $index => $banner)
                    <button @click="activeBanner = {{ $index }}" 
                            class="group relative h-1 flex-1 min-w-[60px] bg-white/20 transition-all overflow-hidden"
                            :class="activeBanner === {{ $index }} ? 'bg-white/40' : ''">
                        <div class="absolute inset-y-0 left-0 bg-white transition-all duration-[5000ms] ease-linear"
                             :style="activeBanner === {{ $index }} ? 'width: 100%' : 'width: 0%'"></div>
                    </button>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Featured Categories Section (Placeholder) -->
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-24 lg:py-32">
        <div class="flex items-end justify-between mb-16 border-l-2 border-black pl-8">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600 block mb-2">Curated Styles</span>
                <h2 class="text-4xl font-black uppercase tracking-tight">The Series 01</h2>
            </div>
            <a href="#" class="text-[11px] font-black uppercase tracking-widest hover:underline underline-offset-8">Explore All &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="group cursor-pointer">
                <div class="aspect-[10/12] bg-gray-50 rounded-[2rem] overflow-hidden mb-8 transform transition-transform duration-700 group-hover:scale-[0.98]">
                    <div class="w-full h-full bg-gray-200 animate-pulse"></div>
                </div>
                <h3 class="text-lg font-black uppercase tracking-tight mb-1">Modernism</h3>
                <p class="text-gray-400 font-medium text-sm">Industrial materials meets artisan craft.</p>
            </div>
            <div class="group cursor-pointer">
                <div class="aspect-[10/12] bg-gray-50 rounded-[2rem] overflow-hidden mb-8 transform transition-transform duration-700 group-hover:scale-[0.98]">
                    <div class="w-full h-full bg-gray-200 animate-pulse"></div>
                </div>
                <h3 class="text-lg font-black uppercase tracking-tight mb-1">Brutalism</h3>
                <p class="text-gray-400 font-medium text-sm">Bold geometry and raw textures.</p>
            </div>
            <div class="group cursor-pointer">
                <div class="aspect-[10/12] bg-gray-50 rounded-[2rem] overflow-hidden mb-8 transform transition-transform duration-700 group-hover:scale-[0.98]">
                    <div class="w-full h-full bg-gray-200 animate-pulse"></div>
                </div>
                <h3 class="text-lg font-black uppercase tracking-tight mb-1">Minimalism</h3>
                <p class="text-gray-400 font-medium text-sm">Quiet luxury and essential forms.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 py-32 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-12 text-center">
            <h2 class="text-3xl font-black italic tracking-tighter uppercase mb-12">MY BRAND</h2>
            <div class="flex justify-center gap-12 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-12">
                <a href="#" class="hover:text-black">Terms</a>
                <a href="#" class="hover:text-black">Privacy</a>
                <a href="#" class="hover:text-black">Shipping</a>
                <a href="#" class="hover:text-black">Press</a>
            </div>
            <p class="text-gray-300 font-medium text-xs">&copy; 2026 My Brand Co. Designed for Excellence.</p>
        </div>
    </footer>

    <script>
        // Simple auto-rotation logic for Alpine.js
        document.addEventListener('alpine:init', () => {
            const el = document.querySelector('[x-data]');
            if (el && el.__x && el.__x.$data.totalBanners > 1) {
                setInterval(() => {
                    const data = el.__x.$data;
                    data.activeBanner = (data.activeBanner + 1) % data.totalBanners;
                }, 5000);
            }
        });
    </script>
</body>
</html>
