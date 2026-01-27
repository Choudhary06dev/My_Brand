@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="container-custom">
            @if(isset($singleBlog))
                <!-- NEWS DETAIL VIEW -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            @if($singleBlog->banner_image || $singleBlog->thumbnail)
                                <div class="h-64 md:h-96 w-full overflow-hidden">
                                    <img src="{{ asset('storage/' . ($singleBlog->banner_image ?? $singleBlog->thumbnail)) }}"
                                        alt="{{ $singleBlog->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif

                            <div class="p-8">
                                <div class="flex items-center text-sm text-gray-500 mb-4 gap-4">
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $singleBlog->published_at ? $singleBlog->published_at->format('F d, Y') : 'Unknown Date' }}
                                    </span>
                                    @if($singleBlog->author)
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $singleBlog->author->name }}
                                        </span>
                                    @endif
                                </div>

                                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">{{ $singleBlog->title }}</h1>

                                <div class="prose max-w-none text-gray-700 leading-relaxed text-lg">
                                    {!! $singleBlog->content !!}
                                </div>

                                <div class="mt-8 pt-8 border-t border-gray-100 flex justify-between items-center">
                                    <a href="{{ route('frontend.news') }}"
                                        class="text-indigo-600 font-semibold hover:text-indigo-800 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Back to News
                                    </a>

                                    <div class="flex gap-2">
                                        <span class="text-gray-500 text-sm font-medium mr-2 self-center">Share:</span>
                                        <button class="text-blue-600 hover:text-blue-800"><svg class="w-5 h-5"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                            </svg></button>
                                        <button class="text-blue-800 hover:text-blue-900"><svg class="w-5 h-5"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                            </svg></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-100">Recent News</h3>
                            <div class="space-y-6">
                                @foreach($recentBlogs as $recent)
                                    <div class="flex gap-4 group">
                                        <a href="{{ route('frontend.news.detail', $recent->id) }}"
                                            class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                            @if($recent->thumbnail)
                                                <img src="{{ asset('storage/' . $recent->thumbnail) }}" alt="{{ $recent->title }}"
                                                    class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                            @else
                                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-xl">📰
                                                </div>
                                            @endif
                                        </a>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 leading-snug mb-1">
                                                <a href="{{ route('frontend.news.detail', $recent->id) }}"
                                                    class="group-hover:text-indigo-600 transition-colors">{{ \Illuminate\Support\Str::limit($recent->title, 40) }}</a>
                                            </h4>
                                            <span
                                                class="text-xs text-gray-500">{{ $recent->published_at ? $recent->published_at->format('M d') : '' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- NEWS LISTING VIEW -->
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2 text-center">News & Insights</h1>
                <p class="text-center text-gray-600 max-w-2xl mx-auto mb-12">Latest updates from AOHT Group.</p>

                @if($blogs->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($blogs as $blog)
                            <div
                                class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col h-full">
                                <a href="{{ route('frontend.news.detail', $blog->id) }}"
                                    class="block h-48 overflow-hidden relative group">
                                    @if($blog->thumbnail)
                                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 text-3xl">📰
                                        </div>
                                    @endif

                                    @if($blog->author)
                                        <div
                                            class="absolute bottom-0 left-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1.5 m-4 rounded-lg shadow-lg flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $blog->author->name }}
                                        </div>
                                    @endif
                                </a>

                                <div class="p-6 flex flex-col flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                        <a href="{{ route('frontend.news.detail', $blog->id) }}"
                                            class="hover:text-indigo-600 transition-colors">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>
                                    <a href="{{ route('frontend.news.detail', $blog->id) }}"
                                        class="text-indigo-600 font-semibold hover:text-indigo-800 inline-flex items-center mt-auto">
                                        Read Full Story
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 flex justify-center">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <p class="text-gray-500 text-lg">No news articles found.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection