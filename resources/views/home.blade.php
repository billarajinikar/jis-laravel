@extends('layouts.app')
@section('title', 'Find English Speaking Jobs in Stockholm, Gothenburg, and Malmö | Jobs in Sweden')
@section('meta')
    <meta name="description" content="Discover English speaking jobs in Stockholm, Gothenburg, Malmö, and across Sweden. Explore opportunities in IT, engineering, customer support, and more. Start your career in Sweden today!">
    <meta name="keywords" content="English speaking jobs, Stockholm jobs, Gothenburg jobs, Malmö jobs, jobs in Sweden, international jobs Sweden, IT jobs Sweden, customer support Sweden">
    <meta property="og:title" content="Find English Speaking Jobs in Stockholm, Gothenburg, and Malmö | Jobs in Sweden">
    <meta property="og:description" content="Discover the best English speaking job opportunities in Stockholm, Gothenburg, Malmö, and across Sweden. Start your career journey today!">
    <meta property="og:image" content="{{ url('images/Logo_JobsinSweden.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <link rel="canonical" href="{{ url('/') }}">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Find English Speaking Jobs in Stockholm, Gothenburg, and Malmö | Jobs in Sweden",
        "description": "Discover English speaking job opportunities in Stockholm, Gothenburg, Malmö, and across Sweden. Explore IT, engineering, customer support jobs, and more.",
        "url": "{{ url('/') }}"
    }
    </script>
@endsection


@section('content')
    <div class="container mt-2 mb-5">
        <div class="text-center mb-4">
            <h1>Welcome to JobsinSweden.se</h1>
            <p>Welcome to JobsinSweden.se, where you can find many job opportunities to help grow your career. Whether you’re just starting, building your skills, or looking for a fresh start, our platform connects you to jobs across Sweden’s top industries. Begin exploring today and take the next step toward your future in Sweden! </p>
        </div>
    </div>
    <div class="container mt-2 mb-5">
        <div class="text-center mb-4">
            @include('sections.categories', ['categories' => $categories])
        </div>
    </div>
    <div class="container mt-2 mb-5">
        <div class="text-center mb-4">
            @include('sections.cities', ['cities' => $cities])
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                @include('home-faqs', ['faqs' => $faqs])
            </div>
            <div class="col-md-6">
                @include('blog.titles', ['posts' => $posts])
            </div> 
        </div>
    </div>
@endsection