<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">



    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/gigz.min.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.2) !important;
        }

        .modal-backdrop.show {
            opacity: 1 !important;
            backdrop-filter: blur(1px) !important;
            -webkit-backdrop-filter: blur(1px) !important;
        }
    </style>

</head>


<body class="@yield('page-class')">
    @auth
        @include('layouts.sidebars.owner')
    @endauth

    <!-- RIGHT SIDE -->
    <div data-content class="min-h-screen flex flex-col">

        <!-- NAVBAR -->
        <div class="bg-white border-b">
            @include('layouts.navigation.owner')
        </div>

        <!-- CONTENT -->
        <main style="padding: 20px; flex: 1;">
            @yield('content')
        </main>

    </div>

    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>
    <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('assets/js/charts/dashboard.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>
    <script src="{{ asset('assets/vendor/gsap/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/gsap/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap-init.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>

    <script src="{{ asset('assets/js/gigz.js') }}" defer></script>

    {{-- Bootstrap --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap === 'undefined') return;

            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(toggle) {
                bootstrap.Dropdown.getOrCreateInstance(toggle);
            });

            function closeAllDropdowns() {
                document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(toggle) {
                    const inst = bootstrap.Dropdown.getInstance(toggle);
                    if (inst) inst.hide();
                });

                document.querySelectorAll('.dropdown-menu.show').forEach(m => m.classList.remove('show'));
                document.querySelectorAll('.dropdown-toggle.show').forEach(t => t.classList.remove('show'));
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) closeAllDropdowns();
            });

            window.addEventListener('pageshow', closeAllDropdowns);
        });
    </script>

    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
    <script src="https://unpkg.com/@hotwired/turbo@8.0.0/dist/turbo.es2017-umd.js"></script>

    @stack('scripts')
</body>

</html>
