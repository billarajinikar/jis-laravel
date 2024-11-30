@extends('layouts.app')

@section('title', 'English speaking Jobs in Stockholm, Göteberg, Malmö')

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