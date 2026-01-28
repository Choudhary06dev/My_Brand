@extends('frontend.layouts.app')

@section('content')
<style>
    .contact-hero {
        background-image: linear-gradient(rgba(17, 24, 39, 0.7), rgba(17, 24, 39, 0.7)), url('{{ asset("assets/contact_hero.png") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .floating-anim {
        animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .input-premium {
        background: rgba(243, 244, 246, 0.5);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-premium:focus {
        background: #fff;
        border-color: #7c3aed;
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
        transform: translateY(-2px);
    }

    .gradient-text {
        background: linear-gradient(to right, #818cf8, #c084fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div class="relative overflow-hidden bg-white">
    <!-- Hero Section -->
    <section class="contact-hero relative py-32 md:py-48 px-4 text-center">
        <div class="relative z-10 max-w-4xl mx-auto" data-aos="fade-up">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-indigo-300 uppercase bg-white/10 rounded-full backdrop-blur-sm border border-white/20">
                Get In Touch
            </span>
            <h1 class="text-5xl md:text-7xl font-black text-white mb-8 tracking-tight">
                Let's Start a <span class="gradient-text">Conversation</span>
            </h1>
            <p class="text-xl text-gray-300 leading-relaxed max-w-2xl mx-auto">
                {{ $company->tagline ?? 'Quality and Innovation at every step.' }} 
                We're here to help you achieve your goals with our premium solutions.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container-custom mt-20 relative z-20 pb-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left: Contact Form -->
            <div class="lg:col-span-6 bg-white rounded-[2.5rem] shadow-2xl p-6 md:p-10 border border-gray-100" data-aos="fade-right">
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-gray-900 mb-3">Send us a Message</h2>
                    <p class="text-gray-500 text-sm">Expect a response within 24 hours.</p>
                </div>

                @if(session('success'))
                    <div class="mb-8 p-6 bg-green-50 border-l-4 border-green-500 rounded-xl flex items-center shadow-sm">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4 shrink-0 text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="text-green-800 font-bold">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('frontend.contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-wider text-gray-400 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name" 
                                class="w-full px-6 py-4 rounded-2xl input-premium @error('name') border-red-500 @enderror" required>
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-wider text-gray-400 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="hello@company.com" 
                                class="w-full px-6 py-4 rounded-2xl input-premium @error('email') border-red-500 @enderror" required>
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-wider text-gray-400 ml-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+92 000 0000000" 
                                class="w-full px-6 py-4 rounded-2xl input-premium">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-wider text-gray-400 ml-1">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Inquiry about..." 
                                class="w-full px-6 py-4 rounded-2xl input-premium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-wider text-gray-400 ml-1">Message</label>
                        <textarea name="message" rows="5" placeholder="Tell us more about your needs..." 
                            class="w-full px-6 py-4 rounded-2xl input-premium @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
                        @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-lg transition-all transform hover:-translate-y-1 shadow-xl hover:shadow-indigo-200 flex items-center justify-center group">
                        <span>Launch Message</span>
                        <i class="fas fa-paper-plane ml-3 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    </button>
                </form>
            </div>

            <!-- Right: Info Side -->
            <div class="lg:col-span-6 flex flex-col gap-8">
                
                <!-- Profile/Support Card -->
                <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group shadow-2xl" data-aos="fade-left">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32 blur-3xl group-hover:bg-white/10 transition-colors"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex items-center gap-6 mb-8">
                            <div class="relative items-center">
                                <img src="{{ asset('assets/support_person.png') }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-white/20 shadow-2xl floating-anim" alt="Support">
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-4 border-indigo-900 rounded-full"></span>
                            </div>
                            <div>
                                <h4 class="text-xl font-black">24/7 Priority Support</h4>
                                <p class="text-indigo-200 text-sm">Always here to help you</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6 mt-auto">
                            <a href="mailto:{{ $company->email }}" class="flex items-center p-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition-all">
                                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-indigo-300"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-black tracking-widest text-indigo-300 opacity-70">Email Us</p>
                                    <p class="font-bold">{{ $company->email }}</p>
                                </div>
                            </a>

                            <a href="tel:{{ $company->phone }}" class="flex items-center p-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition-all">
                                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-phone-alt text-indigo-300"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-black tracking-widest text-indigo-300 opacity-70">Call Direct</p>
                                    <p class="font-bold">{{ $company->phone }}</p>
                                </div>
                            </a>

                            <div class="flex items-center p-4 bg-white/5 border border-white/10 rounded-2xl">
                                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-indigo-300"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-black tracking-widest text-indigo-300 opacity-70">Office Address</p>
                                    <p class="font-bold">{{ $company->address }}<br>{{ $company->city }}, {{ $company->country }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hours Card -->
                <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white flex flex-col relative overflow-hidden group shadow-2xl" data-aos="fade-left" data-aos-delay="100">
                    <div class="absolute bottom-0 right-0 w-48 h-48 bg-indigo-500/10 rounded-full -mb-24 -mr-24 blur-3xl"></div>
                    <h3 class="text-2xl font-black mb-8 flex items-center">
                        <i class="fas fa-clock mr-4 text-indigo-400"></i> Operational Hours
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-white/5">
                            <span class="text-gray-400 font-bold">Mon — Fri</span>
                            <span class="font-black text-indigo-400">09:00 — 18:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-white/5">
                            <span class="text-gray-400 font-bold">Saturday</span>
                            <span class="font-black text-indigo-400">09:00 — 14:00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 font-bold">Sunday</span>
                            <span class="font-black text-red-500 uppercase tracking-widest text-sm">Closed</span>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="flex gap-4" data-aos="fade-up">
                    <a href="#" class="flex-1 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:shadow-xl transition-all"><i class="fab fa-facebook-f text-xl"></i></a>
                    <a href="#" class="flex-1 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 hover:text-indigo-400 hover:shadow-xl transition-all"><i class="fab fa-twitter text-xl"></i></a>
                    <a href="#" class="flex-1 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 hover:text-pink-600 hover:shadow-xl transition-all"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="flex-1 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 hover:text-indigo-800 hover:shadow-xl transition-all"><i class="fab fa-linkedin-in text-xl"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AOS Library for scroll animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        easing: 'ease-out-cubic'
    });
</script>
@endsection