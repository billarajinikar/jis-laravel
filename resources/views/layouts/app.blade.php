<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="/images/favicon.png" sizes="32x32" type="image/png">
        <title>@yield('title') - JobsinSweden.se</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            html, body {
                height: 100%;
            }

            body {
                display: flex;
                flex-direction: column;
                margin: 0;
            }

            #app {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .content {
                flex: 1;
            }

            footer {
                background-color: #343a40;
                color: white;
                text-align: center;
                padding: 1rem 0;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Main Content -->
            <main class="content py-4">
                <div class="container">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer>
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-4"><a href="/about-us">About Us</a></div>
                        <div class="col-md-4"><a href="/contact-us">Contact Us</a></div>
                        <div class="col-md-4"><a href="/privacy-policy">Privacy policy</a></div>
                    </div>
                </div>
                <div class="container text-center">&copy; {{ date('Y') }} JobsinSweden</div>
            </footer>
        </div>
        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FV0LQJXTWV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-FV0LQJXTWV');
</script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
