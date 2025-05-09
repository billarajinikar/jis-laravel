<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Browse English-speaking job opportunities in Sweden. Resources and tips for new arrivals.')">
    <meta property="og:title" content="@yield('title', 'Jobs in Sweden')">
    <meta property="og:description" content="@yield('meta_description', 'Find jobs and career advice for living and working in Sweden.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/social-preview.png') }}">

    <title>@yield('title', 'Jobs in Sweden - Start Your Journey')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @stack('styles')
</head>
<body>
    <a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>

    <div id="guest">
        <nav role="navigation">
            @include('navigation')
        </nav>

        <main id="main-content" role="main" class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
