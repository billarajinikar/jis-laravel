@extends('layouts.app')

@section('title', 'Frequently Asked Questions - JobsinSweden.se')

@section('content')
    <div class="container mt-2 mb-5">
        <div class="text-center mb-4">
            <h1>Frequently Asked Questions</h1>
            <p>Here you can find answers to some of the most common questions about finding jobs in Sweden for English-speaking people.</p>
        </div>

        <!-- All FAQs Section -->
        <div class="container">
            <div class="accordion" id="allFaqAccordion">
                @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="allHeading{{ $index }}">
                            <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#allCollapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="allCollapse{{ $index }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="allCollapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="allHeading{{ $index }}" data-bs-parent="#allFaqAccordion">
                            <div class="accordion-body">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
