@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-10">
        <div class="container-custom">
            <div class="text-center mb-8">
                <h1 class="text-5xl font-extrabold text-gray-900 mb-6">Contact Us</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    A One Home Textile Group is committed to excellence in quality and innovation.
                    Whether you have inquiries about our premium textile products, partnership opportunities,
                    or need expert assistance, we're here to help you weave success.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Left Column (Form and Hours) -->
                <div class="flex flex-col h-full space-y-8">
                    <!-- Contact Form Card -->
                    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
                            <svg class="h-8 w-8 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Send a Message
                        </h2>

                        @if(session('success'))
                            <div class="mb-8 p-5 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-lg shadow-sm">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('frontend.contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name"
                                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-4 px-5 bg-gray-50 border transition-all duration-200 @error('name') border-red-500 @enderror"
                                        placeholder="John Doe" required>
                                    @error('name') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email"
                                        class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-4 px-5 bg-gray-50 border transition-all duration-200 @error('email') border-red-500 @enderror"
                                        placeholder="john@example.com" required>
                                    @error('email') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number
                                    (Optional)</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-4 px-5 bg-gray-50 border transition-all duration-200"
                                    placeholder="+92 300 0000000">
                                @error('phone') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-4 px-5 bg-gray-50 border transition-all duration-200"
                                    placeholder="How can we help?">
                                @error('subject') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Your Message</label>
                                <textarea id="message" name="message" rows="5"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-4 px-5 bg-gray-50 border transition-all duration-200 @error('message') border-red-500 @enderror"
                                    placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                                @error('message') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center py-4 px-8 border border-transparent shadow-lg text-lg font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-1">
                                    Send Message
                                    <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Business Hours Card -->
                    <div
                        class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-xl overflow-hidden relative group flex-grow">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-indigo-100 transition-colors duration-500">
                        </div>
                        <div class="relative z-10 h-full flex flex-col">
                            <h3 class="text-2xl font-black text-gray-900 mb-8 tracking-tight flex items-center">
                                <span
                                    class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mr-4 text-indigo-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Operational Hours
                            </h3>
                            <div class="space-y-4 mt-auto">
                                <div
                                    class="flex justify-between items-center p-5 bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-indigo-100 hover:bg-white transition-all duration-300">
                                    <span class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em]">Mon —
                                        Fri</span>
                                    <span class="text-indigo-600 font-black text-sm">09:00 AM — 06:00 PM</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-5 bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-indigo-100 hover:bg-white transition-all duration-300">
                                    <span
                                        class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em]">Saturday</span>
                                    <span class="text-indigo-400 font-black text-sm">09:00 AM — 02:00 PM</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-5 bg-red-50/30 rounded-2xl border border-red-50">
                                    <span
                                        class="text-red-600 font-bold uppercase text-[10px] tracking-[0.2em]">Sunday</span>
                                    <span class="text-red-500 font-black text-sm">Closed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Contact Cards & Info -->
                <div class="space-y-8 h-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Main HQ Card (Solid Color Fallback + Gradient) -->
                        <div class="group relative bg-indigo-900 bg-gradient-to-br from-indigo-800 to-indigo-950 rounded-[2.5rem] p-8 shadow-xl transition-all duration-500 hover:-translate-y-2 overflow-hidden border border-white/10"
                            style="background-color: #1a237e;">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 blur-2xl">
                            </div>
                            <div class="relative z-10 h-full flex flex-col">
                                <div class="flex items-center justify-between mb-8">
                                    <div>
                                        <h3 class="text-2xl font-black text-white tracking-tight">
                                            {{ $company->company_name ?? 'AOHT Group' }}
                                        </h3>
                                        <p class="text-indigo-200 text-[10px] font-black uppercase tracking-[0.2em] mt-1">
                                            Main HQ</p>
                                    </div>
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                </div>
                                @if($company->city || $company->country)
                                    <div class="mb-10"><span
                                            class="bg-white/15 backdrop-blur-md border border-white/20 px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] shadow-lg inline-flex items-center text-white">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-300 mr-3 animate-pulse"></span>
                                            {{ $company->city }}{{ $company->city && $company->country ? ' • ' : '' }}{{ $company->country }}
                                        </span></div>
                                @endif
                                <div class="space-y-5 text-white mt-auto">
                                    <p class="text-[15px] font-bold leading-relaxed">{{ $company->address }}</p>
                                    <div class="pt-6 border-t border-white/10 space-y-4">
                                        <div class="flex items-center text-sm">
                                            <div
                                                class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                                                <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div><span class="font-bold">{{ $company->email }}</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <div
                                                class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                                                <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div><span class="font-bold">{{ $company->phone }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Office Locations Loop (6-Color Premium Variety) -->
                        @foreach($officeLocations as $index => $location)
                            @php
                                $cardStyle = '';
                                $cardBg = '';
                                switch ($index % 6) {
                                    case 0: // Emerald
                                        $cardBg = 'bg-emerald-800 bg-gradient-to-br from-emerald-600 to-emerald-900 shadow-emerald-900/40';
                                        $cardStyle = 'background-color: #065f46;';
                                        break;
                                    case 1: // Orange
                                        $cardBg = 'bg-orange-600 bg-gradient-to-br from-orange-500 to-orange-700 shadow-orange-900/40';
                                        $cardStyle = 'background-color: #c2410c;';
                                        break;
                                    case 2: // Rose
                                        $cardBg = 'bg-rose-700 bg-gradient-to-br from-rose-600 to-rose-800 shadow-rose-900/40';
                                        $cardStyle = 'background-color: #be123c;';
                                        break;
                                    case 3: // Luxury Purple
                                        $cardBg = 'bg-purple-800 bg-gradient-to-br from-purple-700 to-purple-900 shadow-purple-900/40';
                                        $cardStyle = 'background-color: #6b21a8;';
                                        break;
                                    case 4: // Royal Blue
                                        $cardBg = 'bg-blue-800 bg-gradient-to-br from-blue-700 to-blue-900 shadow-blue-900/40';
                                        $cardStyle = 'background-color: #1e40af;';
                                        break;
                                    case 5: // Crimson Pink
                                        $cardBg = 'bg-pink-700 bg-gradient-to-br from-pink-600 to-pink-800 shadow-pink-900/40';
                                        $cardStyle = 'background-color: #be185d;';
                                        break;
                                }
                            @endphp
                            <div class="group relative {{ $cardBg }} rounded-[2.5rem] p-8 shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden border border-white/10"
                                style="{{ $cardStyle }}">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 blur-2xl">
                                </div>
                                <div class="relative z-10 h-full flex flex-col text-white">
                                    <div class="flex items-center justify-between mb-8">
                                        <h3 class="text-2xl font-black tracking-tight drop-shadow-sm">{{ $location->title }}
                                        </h3>
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shadow-lg">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                        </div>
                                    </div>

                                    @if($location->city || $location->country)
                                        <div class="mb-10 self-start">
                                            <span
                                                class="bg-white/15 backdrop-blur-md border border-white/20 px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] shadow-lg inline-flex items-center">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-300 mr-3 animate-pulse"></span>
                                                {{ $location->city }}{{ $location->city && $location->country ? ' • ' : '' }}{{ $location->country }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="space-y-6 mt-auto">
                                        <p class="text-[15px] font-bold leading-relaxed line-clamp-2">
                                            {{ $location->address ?? 'Office Address available' }}
                                        </p>
                                        <div class="pt-6 border-t border-white/20 space-y-4">
                                            @if($location->email)
                                                <div class="flex items-center text-sm group/contact">
                                                    <div
                                                        class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center mr-4 group-hover/contact:bg-white/20 transition-colors">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <span class="font-bold tracking-tight">{{ $location->email }}</span>
                                                </div>
                                            @endif
                                            @if($location->phone)
                                                <div class="flex items-center text-sm group/contact">
                                                    <div
                                                        class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center mr-4 group-hover/contact:bg-white/20 transition-colors">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                    </div>
                                                    <span class="font-bold tracking-tight">{{ $location->phone }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection