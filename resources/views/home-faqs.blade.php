<div>
    <h2 class="text-center mb-4">Frequently asked questions</h2>
    <div class="mt-4">
        <div class="container">
            @if($posts->count())
                <div class="list-group">
                    @foreach($faqs as $index => $faq)
                    <a  class="list-group-item list-group-item-action" style="font-weight: bold; color: #32cd32; text-decoration: none;" href="/ask-me/{{ $faq->id }}/{{ str_replace(' ', '-', str_replace('?', '', $faq->question)) }}">
                        <p>{{ $faq->question }}</p>
                    </a>
                    @endforeach
                </div>
            @else
                <p>No questions available.</p>
            @endif
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('faqs') }}" class="btn btn-primary">View All Questions</a>
    </div>
</div>