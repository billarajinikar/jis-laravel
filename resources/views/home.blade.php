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
        <!-- FAQ Section -->
        <div class="col-md-6">
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>
            <div class="accordion" id="faqAccordion">
                @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                <b>{{ $faq->question }}</b>
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('faqs') }}" class="btn btn-primary">View All FAQs</a>
            </div>
        </div>
        <div class="col-md-6">
            @include('blog.titles', ['posts' => $posts])
        </div>
        
    </div>
@endsection