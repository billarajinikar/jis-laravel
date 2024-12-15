@extends('layouts.app')
@section('title', 'Page not found')

@section('content')
<div class="container text-center" style="margin-top: 50px;">
    <h1 style="font-size: 48px; color: #ff4a4a;">404 - Page Not Found</h1>
    <p style="font-size: 18px; color: #555;">
        Sorry, the page you are looking for could not be found. This job advertisement may have expired or been removed.
    </p>
    <p style="font-size: 16px; color: #666;">
        Browse other job listings or return to the homepage to continue exploring.
    </p>
    <a href="{{ url('/') }}" style="text-decoration: none; color: white; background-color: #007bff; padding: 10px 20px; border-radius: 5px;">
        Go to Homepage
    </a>
    <br><br>
    <a href="{{ url('/find-a-job-in-sweden') }}" style="text-decoration: none; color: #007bff; font-size: 16px;">
        Check Other Jobs
    </a>
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
