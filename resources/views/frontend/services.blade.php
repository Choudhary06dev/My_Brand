@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="container-custom">
            @if(isset($singleService))
                <!-- SERVICE DETAIL VIEW -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            @if($singleService->banner_image)
                                <div class="h-64 md:h-80 w-full overflow-hidden">
                                    @if(\Illuminate\Support\Str::startsWith($singleService->banner_image, ['http://', 'https://']))
                                        <img src="{{ $singleService->banner_image }}" alt="{{ $singleService->service_name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('storage/' . $singleService->banner_image) }}"
                                            alt="{{ $singleService->service_name }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            @else
                                <div
                                    class="h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white text-4xl">
                                    {{ substr($singleService->service_name, 0, 1) }}
                                </div>
                            @endif

                            <div class="p-8">
                                <div class="flex items-center gap-4 mb-6">
                                    @if($singleService->icon)
                                        <div class="w-16 h-16 bg-indigo-50 rounded-lg flex items-center justify-center p-2">
                                            @if(\Illuminate\Support\Str::contains($singleService->icon, ['http://', 'https://']) || \Illuminate\Support\Str::contains($singleService->icon, ['.jpg', '.png', '.jpeg', '.svg', '.webp']))
                                                @if(\Illuminate\Support\Str::startsWith($singleService->icon, ['http://', 'https://']))
                                                    <img src="{{ $singleService->icon }}" class="w-full h-full object-contain">
                                                @else
                                                    <img src="{{ asset('storage/' . $singleService->icon) }}"
                                                        class="w-full h-full object-contain">
                                                @endif
                                            @else
                                                <i class="{{ $singleService->icon }}" style="font-size: 2rem; color: #4f46e5;"></i>
                                            @endif
                                        </div>
                                    @endif
                                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">
                                        {{ $singleService->service_name }}
                                    </h1>
                                </div>

                                <div class="prose max-w-none text-gray-700 leading-relaxed text-lg">
                                    {!! $singleService->description !!}
                                </div>

                                <div class="mt-8 pt-8 border-t border-gray-100">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4">Interested in this service?</h3>
                                    <a href="{{ route('frontend.contact') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                        Contact Us Today
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 sticky top-24">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-100">Other Services</h3>
                            <div class="space-y-4">
                                @foreach($otherServices as $other)
                                    <a href="{{ route('frontend.services.detail', $other->slug) }}"
                                        class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                        @if($other->icon)
                                            <div
                                                class="w-10 h-10 flex-shrink-0 bg-indigo-50 rounded-md p-1 mr-3 flex items-center justify-center">
                                                @if(\Illuminate\Support\Str::contains($other->icon, ['http://', 'https://']) || \Illuminate\Support\Str::contains($other->icon, ['.jpg', '.png', '.jpeg', '.svg', '.webp']))
                                                    @if(\Illuminate\Support\Str::startsWith($other->icon, ['http://', 'https://']))
                                                        <img src="{{ $other->icon }}" class="w-6 h-6 object-contain">
                                                    @else
                                                        <img src="{{ asset('storage/' . $other->icon) }}" class="w-6 h-6 object-contain">
                                                    @endif
                                                @else
                                                    <i class="{{ $other->icon }}" style="font-size: 1.25rem; color: #4f46e5;"></i>
                                                @endif
                                            </div>
                                        @else
                                            <div
                                                class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-md mr-3 flex items-center justify-center text-gray-500 font-bold">
                                                {{ substr($other->service_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span
                                            class="font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $other->service_name }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 ml-auto text-gray-400 group-hover:text-indigo-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                                <a href="{{ route('frontend.services') }}"
                                    class="text-indigo-600 font-semibold hover:text-indigo-800 text-sm">View All Services</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- SERVICES LISTING VIEW -->
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4 text-center">Our Services</h1>
                <p class="text-center text-gray-600 max-w-3xl mx-auto mb-12">We offer a wide range of comprehensive solutions
                    tailored to meet your unique business needs.</p>

                @if($services->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($services as $service)
                            <div
                                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300 group">
                                <a href="{{ route('frontend.services.detail', $service->slug) }}" class="block h-full">
                                    @if($service->banner_image)
                                        <div class="h-48 overflow-hidden">
                                            @if(Str::startsWith($service->banner_image, ['http://', 'https://']))
                                                <img src="{{ $service->banner_image }}" alt="{{ $service->service_name }}"
                                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->service_name }}"
                                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                            @endif
                                        </div>
                                    @endif

                                    <div class="p-8">
                                        <div class="flex items-center gap-4 mb-4">
                                            @if($service->icon)
                                                <div
                                                    class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                                                    @if(\Illuminate\Support\Str::contains($service->icon, ['http://', 'https://']) || \Illuminate\Support\Str::contains($service->icon, ['.jpg', '.png', '.jpeg', '.svg', '.webp']))
                                                        @if(\Illuminate\Support\Str::startsWith($service->icon, ['http://', 'https://']))
                                                            <img src="{{ $service->icon }}" class="w-8 h-8 object-contain">
                                                        @else
                                                            <img src="{{ asset('storage/' . $service->icon) }}" class="w-8 h-8 object-contain">
                                                        @endif
                                                    @else
                                                        <i class="{{ $service->icon }} text-2xl"></i>
                                                    @endif
                                                </div>
                                            @endif
                                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $service->service_name }}
                                            </h3>
                                        </div>


                                        <span
                                            class="inline-flex items-center text-indigo-600 font-semibold group-hover:text-indigo-800 transition-colors">
                                            Learn More
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-lg shadow">
                        <p class="text-gray-500 text-lg">Services are currently being updated. Please check back later.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection