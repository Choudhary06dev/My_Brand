<footer class="site-footer bg-gray-950 text-white pt-6">
    <!-- Main Footer Grid -->
    <div class="container-custom footer-main pb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            
            <!-- Brand Column -->
            <div class="footer-column" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ url('/') }}" class="footer-logo-link inline-block">
                    <img src="{{ asset('assets/logo.png') }}" class="footer-logo h-16 mb-6 brightness-0 invert"
                        alt="{{ $company->company_name ?? config('app.name') }}">
                </a>
                <p class="footer-about text-gray-400 mb-2 leading-relaxed text-sm">
                    {{ config('app.name') }} is a premier brand dedicated to textile excellence, delivering premium quality fabrics and garments with a commitment to innovation and craftsmanship.
                </p>
                <div class="social-links-modern flex gap-4">
                    <a href="#" class="social-icon-modern group w-10 h-10 rounded-full bg-gray-900 border border-white/5 flex items-center justify-center hover:bg-indigo-600 transition-all duration-300 shadow-lg"><i class="fab fa-facebook-f text-white group-hover:scale-110"></i></a>
                    <a href="#" class="social-icon-modern group w-10 h-10 rounded-full bg-gray-900 border border-white/5 flex items-center justify-center hover:bg-sky-500 transition-all duration-300 shadow-lg"><i class="fab fa-twitter text-white group-hover:scale-110"></i></a>
                    <a href="#" class="social-icon-modern group w-10 h-10 rounded-full bg-gray-900 border border-white/5 flex items-center justify-center hover:bg-pink-600 transition-all duration-300 shadow-lg"><i class="fab fa-instagram text-white group-hover:scale-110"></i></a>
                    <a href="#" class="social-icon-modern group w-10 h-10 rounded-full bg-gray-900 border border-white/5 flex items-center justify-center hover:bg-blue-700 transition-all duration-300 shadow-lg"><i class="fab fa-linkedin-in text-white group-hover:scale-110"></i></a>
                </div>
            </div>

            <!-- Company Column -->
            <div class="footer-column" data-aos="fade-up" data-aos-delay="200">
                <h3 class="footer-heading text-white font-black text-xl mb-4 relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-12 after:h-1 after:bg-indigo-600">Company</h3>
                <ul class="footer-links space-y-4">
                    <li><a href="{{ route('frontend.about') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> About Our Brand</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> Get In Touch</a></li>
                    <li><a href="{{ route('frontend.categories') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> Shop Collection</a></li>
                    <li><a href="{{ route('frontend.news') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> Latest News</a></li>
                </ul>
            </div>

            <!-- Services Column -->
            <div class="footer-column" data-aos="fade-up" data-aos-delay="300">
                <h3 class="footer-heading text-white font-black text-xl mb-4 relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-12 after:h-1 after:bg-indigo-600">Our Services</h3>
                <ul class="footer-links space-y-4">
                    @if(isset($services) && $services->count() > 0)
                        @foreach($services->take(4) as $s)
                            <li><a href="{{ route('frontend.services.detail', $s->slug) }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> {{ $s->service_name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('frontend.services') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> IT Solutions</a></li>
                        <li><a href="{{ route('frontend.services') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> Real Estate</a></li>
                        <li><a href="{{ route('frontend.services') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> HR Outsourcing</a></li>
                        <li><a href="{{ route('frontend.services') }}" class="text-gray-400 hover:text-indigo-500 transition-all duration-300 flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-indigo-600 scale-0 group-hover:scale-100 transition-transform"></span> Consultancy</a></li>
                    @endif
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="footer-column" data-aos="fade-up" data-aos-delay="400">
                <h3 class="footer-heading text-white font-black text-xl mb-4 relative pb-4 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-12 after:h-1 after:bg-indigo-600">Contact Info</h3>
                <ul class="contact-info-list space-y-6">
                    <li class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 border border-white/5 flex items-center justify-center shrink-0 text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300"><i class="fas fa-map-marker-alt"></i></div>
                        <span class="text-gray-400 text-sm py-1 group-hover:text-gray-200 transition-colors">{{ $company->address ?? 'Karachi, Pakistan' }}</span>
                    </li>
                    <li class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 border border-white/5 flex items-center justify-center shrink-0 text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300"><i class="fas fa-envelope"></i></div>
                        <a href="mailto:{{ $company->email ?? 'info@example.com' }}" class="text-gray-400 hover:text-gray-200 transition-all duration-300 text-sm py-1">{{ $company->email ?? 'info@example.com' }}</a>
                    </li>
                    <li class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 border border-white/5 flex items-center justify-center shrink-0 text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300"><i class="fas fa-phone-alt"></i></div>
                        <a href="tel:{{ $company->phone ?? '+923001234567' }}" class="text-gray-400 hover:text-gray-200 transition-all duration-300 text-sm py-1">{{ $company->phone ?? '+92 300 1234567' }}</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Bottom Copyright Bar -->
    <div class="footer-bottom py-8 border-t border-white/5 bg-black">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="copyright-year text-gray-500 text-sm">
                    © {{ now()->year }} <span class="font-bold text-gray-300">{{ $company->company_name ?? config('app.name') }}</span> — All rights reserved.
                </div>
                <div class="footer-legal-links flex gap-8 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-all duration-300 underline underline-offset-4 decoration-indigo-600/30">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-all duration-300 underline underline-offset-4 decoration-indigo-600/30">Terms of Use</a>
                </div>
                <div class="powered-by text-sm text-gray-500 flex items-center gap-2">
                    Crafted with <i class="fas fa-heart text-red-600 animate-pulse"></i> by 
                    <a href="https://nexertechsolutions.com" target="_blank" class="font-black text-indigo-500 hover:text-indigo-400 hover:scale-105 transition-all">Nexer Tech Solutions</a>
                </div>
            </div>
        </div>
    </div>
</footer>