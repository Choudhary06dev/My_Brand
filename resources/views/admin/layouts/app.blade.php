<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        window.CKEDITOR_BASEPATH = '//cdn.ckeditor.com/4.22.1/standard/';
    </script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('admin.layouts.partials.sidebar')

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Navbar -->
            @include('admin.layouts.partials.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @isset($header)
                    <!-- Optional Header for breadcrumbs or page titles if passed -->
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endisset

                <div class="px-4 sm:px-6 lg:px-8">
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('admin.layouts.partials.footer')
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const alerts = document.querySelectorAll('[role="alert"]');
                alerts.forEach(function (alert) {
                    alert.style.transition = 'opacity 0.3s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function () {
                        alert.remove();
                    }, 500);
                });
            }, 5000);
        });
    </script>
    <script>
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.config.versionCheck = false;
        }
    </script>
    @stack('scripts')
</body>

</html>