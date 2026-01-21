<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Custom CSS & JS (Vite handles Bootstrap import) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color: var(--color-bg);">
    <div class="min-vh-100 d-flex flex-column">
        
        {{-- Navbar --}}
        @include('layouts.navigation')

        {{-- Page Header --}}
        @isset($header)
            <header class="bg-white shadow-sm mb-4 py-3">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Main Content --}}
        <main class="container flex-grow-1 mb-5">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="text-center py-4 mt-auto small text-muted">
            &copy; {{ date('Y') }} BatiKa. All rights reserved.
        </footer>

    </div>

    {{-- Bootstrap JS (If not handled by app.js yet, keep CDN or remove if handled) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <!-- SweetAlert Toast Script -->
    <x-sweetalert-toast />
</body>
</html>
