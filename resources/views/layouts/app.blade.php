<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - JobsinSweden.se</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <main class="py-4">
                <div class="container">
                    @yield('content')
                </div>
            </main>

            <footer class="bg-dark text-white py-3 mt-4">
                <div class="container text-center">&copy; {{ date('Y') }} JobsinSweden</div>
            </footer>
        </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
