@extends('layouts.app')
@section('title', 'Page not found')

@section('content')
<div class="container">
    <h1>404 - Page Not Found</h1>
    <p>Sorry, the page you are looking for could not be found.</p>
    <a href="{{ url('/') }}">Go to Homepage</a>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8349643691635774"
     crossorigin="anonymous"></script>
<!-- HorizontalDipsplayAds -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8349643691635774"
     data-ad-slot="1829880624"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
@endsection
