@extends('frontend.layouts.app')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
<style>
    .contact-page {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(1100px 500px at 0% 0%, rgba(99, 102, 241, 0.14), transparent 55%),
            radial-gradient(900px 460px at 100% 20%, rgba(6, 182, 212, 0.12), transparent 56%),
            #f8fafc;
    }

    .contact-hero {
        background-image: linear-gradient(115deg, rgba(15, 23, 42, 0.94) 0%, rgba(30, 41, 59, 0.86) 45%, rgba(30, 64, 175, 0.72) 100%),
        url('{{ asset("assets/contact_hero.png") }}');
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .contact-surface-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1.5rem;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
        padding: 2rem;
    }

    .contact-input {
        width: 100%;
        border-radius: 0.9rem;
        border: 1.8px solid #dbe2ea;
        background: #f8fafc;
        padding: 0.85rem 1rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        outline: none;
    }

    .contact-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        background: #ffffff;
    }

    .contact-input.error {
        border-color: #ef4444;
    }

    .contact-info-item {
        display: flex;
        gap: 0.9rem;
        align-items: flex-start;
        padding: 0.9rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.95rem;
        background: #f9fafb;
        transition: border-color 0.25s ease, transform 0.25s ease;
    }

    a.contact-info-item:hover {
        transform: translateY(-2px);
        border-color: rgba(99, 102, 241, 0.55);
    }

    .contact-info-icon {
        width: 2.4rem;
        height: 2.4rem;
        border-radius: 0.7rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.13), rgba(59, 130, 246, 0.16));
        color: #4f46e5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-hours-card {
        background: linear-gradient(140deg, #111827 0%, #1f2937 50%, #1e3a8a 100%);
        border-radius: 1.5rem;
        color: #ffffff;
        padding: 1.6rem;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.3);
    }

    .contact-hours-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.85rem;
        margin-bottom: 0.85rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .contact-hours-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: 0;
    }

    @media (max-width: 768px) {
        .contact-surface-card {
            padding: 1.25rem;
            border-radius: 1.1rem;
        }

    }
</style>
@endpush

@section('content')
@php
$companyTagline = $company->tagline ?? 'Quality and innovation at every step.';
$companyEmail = $company->email ?? null;
$companyPhone = $company->phone ?? null;
$companyAddress = trim(($company->address ?? '') . ' ' . ($company->city ?? '') . ' ' . ($company->country ?? ''));
@endphp

<div class="contact-page">
    <section class="contact-hero pt-32 pb-20 md:pt-40 md:pb-24">
        <div class="container-custom">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight text-white">
                    Tell Us What You Need
                    <span class="block gradient-text">We Reply Quickly</span>
                </h1>
                <p class="mt-5 text-base md:text-lg text-slate-200 leading-relaxed">
                    {{ $companyTagline }} Reach out for product support, service inquiries, or a custom quote.
                    Our team reviews every message carefully.
                </p>
            </div>
        </div>
    </section>

    <div class="h-10 md:h-5"></div>

    <section class="container-custom pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <div class="lg:col-span-7" data-aos="fade-up">
                <div class="contact-surface-card">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Send a Message</h2>
                    <p class="mt-2 text-sm text-gray-500">Fill in your details and our team will get back to you soon.</p>

                    @if(session('success'))
                    <div class="mt-6 p-4 rounded-xl border border-green-200 bg-green-50 text-green-800 flex items-start gap-3">
                        <span class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fas fa-check text-xs"></i>
                        </span>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                    @endif

                    <form action="{{ route('frontend.contact.store') }}" method="POST" class="space-y-5 mt-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name"
                                    class="contact-input @error('name') error @enderror" required>
                                @error('name')
                                <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                                    class="contact-input @error('email') error @enderror" required>
                                @error('email')
                                <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Phone Number</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+92 000 0000000"
                                    class="contact-input">
                            </div>
                            <div>
                                <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Subject</label>
                                <input id="subject" type="text" name="subject" value="{{ old('subject') }}" placeholder="How can we help?"
                                    class="contact-input">
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Please share the details of your request..."
                                class="contact-input @error('message') error @enderror" required>{{ old('message') }}</textarea>
                            @error('message')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-indigo-200">
                            Send Message
                            <i class="fas fa-paper-plane ml-2 text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col gap-6" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-surface-card">
                    <h3 class="text-xl font-extrabold text-gray-900">Reach Us Directly</h3>
                    <p class="text-sm text-gray-500 mt-1">Prefer direct contact? Use the details below.</p>

                    <div class="space-y-3 mt-5">
                        @if($companyEmail)
                        <a href="mailto:{{ $companyEmail }}" class="contact-info-item">
                            <span class="contact-info-icon"><i class="fas fa-envelope"></i></span>
                            <span>
                                <span class="block text-xs uppercase tracking-wider text-gray-400 font-bold">Email</span>
                                <span class="font-semibold text-gray-800 break-all">{{ $companyEmail }}</span>
                            </span>
                        </a>
                        @endif

                        @if($companyPhone)
                        <a href="tel:{{ $companyPhone }}" class="contact-info-item">
                            <span class="contact-info-icon"><i class="fas fa-phone-alt"></i></span>
                            <span>
                                <span class="block text-xs uppercase tracking-wider text-gray-400 font-bold">Phone</span>
                                <span class="font-semibold text-gray-800">{{ $companyPhone }}</span>
                            </span>
                        </a>
                        @endif

                        <div class="contact-info-item">
                            <span class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <span>
                                <span class="block text-xs uppercase tracking-wider text-gray-400 font-bold">Address</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $companyAddress !== '' ? $companyAddress : 'Address details are not available yet.' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="contact-hours-card flex-grow flex flex-col justify-between">
                    <h3 class="text-lg font-extrabold mb-4 flex items-center">
                        <i class="fas fa-clock mr-2 text-indigo-300"></i>
                        Office Hours
                    </h3>
                    <div class="contact-hours-row">
                        <span class="text-slate-300">Mon - Fri</span>
                        <span class="font-semibold">09:00 - 18:00</span>
                    </div>
                    <div class="contact-hours-row">
                        <span class="text-slate-300">Saturday</span>
                        <span class="font-semibold">09:00 - 14:00</span>
                    </div>
                    <div class="contact-hours-row">
                        <span class="text-slate-300">Sunday</span>
                        <span class="font-semibold text-rose-300">Closed</span>
                    </div>
                </div>

                <!-- <div class="contact-surface-card mt-auto">
                    <h3 class="text-xl font-extrabold text-gray-900">Need Product Help?</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Browse our latest products and include item names in your message for faster support.
                    </p>
                    <a href="{{ route('frontend.products') }}"
                        class="inline-flex items-center mt-5 text-indigo-600 font-bold hover:text-indigo-700 transition-colors">
                        View Products
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div> -->
            </div>

            <div class="h-10 md:h-5"></div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 850,
                once: true,
                easing: 'ease-out-cubic'
            });
        }
    });
</script>
@endpush