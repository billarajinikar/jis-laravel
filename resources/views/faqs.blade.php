@extends('layouts.app')

@section('title', 'Frequently Asked Questions - JobsinSweden.se')

@section('content')
<style>
    .card {
        margin-bottom: 30px; /* Adjust vertical spacing */
        background-color:#f8f9fa;
    }
    .card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .row .col-md-6 {
        padding-right: 15px; /* Adjust horizontal spacing */
        padding-left: 15px;
    }
    .upvote-btn.active {
        background-color: #d4edda !important; /* Light green */
        color: #155724 !important; /* Dark green */
    }

    .downvote-btn.active {
        background-color: #f8d7da !important; /* Light red */
        color: #721c24 !important; /* Dark red */
    }
    #answer {
    font-size: 1rem;
    line-height: 1.6;
    margin-top: 15px;
}

#answer ul {
    padding-left: 20px;
}

#answer li {
    margin-bottom: 8px;
}

#answer a {
    color: #007bff;
    text-decoration: none;
}

#answer a:hover {
    text-decoration: underline;
}


</style>

<div class="container py-2">
    <h1 class="text-center mb-4">Ask Your Question</h1>
    <div class="text-center">
        <p class="mb-4">Got questions about life, jobs, or visas in Sweden? Ask us anything, or browse our FAQ to find answers!</p>
    </div>

    <!-- Ask Us Form -->
    <div class="py-4" style="background-color: #f8f9fa; border-radius: 8px;">
        <form id="askForm" method="post" class="mx-auto" style="max-width: 600px;">
            @csrf
            <div class="form-group mb-3">
                <label for="question" class="form-label fw-bold">Your Question</label>
                <textarea class="form-control" id="question" name="question" rows="3" placeholder="Type your question here..." style="border: 1px solid #ced4da; border-radius: 5px;"></textarea>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary px-5" id="submitButton">Ask Me</button>
                <div id="loadingSpinner" class="ms-3" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <small>Processing...</small>
                </div>
            </div>
        </form>
        <div id="answer" class="alert alert-success mt-4 text-center" style="display: none;"></div>
        <div id="error" class="alert alert-danger mt-4 text-center" style="display: none;"></div>
    </div>

   <!-- FAQ Section -->
    <div class="mt-5">
        <h2 class="mb-4 text-center" style="font-size: 2rem; color: #0056b3;">Questions Asked By Others</h2>
        <p class="text-center mb-4" style="font-size: 1.2rem; color: #6c757d;">
            Explore our most frequently asked questions to find quick answers, or click on a question to see more details.
        </p>
        <div class="row gx-5 gy-3">
            @forelse($faqs as $faq)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body">
                            <div class="qtn-title mb-3">
                                <h5 class="card-title fw-bold text-primary "><a class="text-decoration-none" href="/ask-me/{{ $faq->id }}/{{ str_replace(' ', '-', str_replace('?', '', $faq->question)) }}">{{ $faq->question }}</a></h5>
                            </div>
                            <p class="card-text text-muted">
                                {!! \Illuminate\Support\Str::limit(strip_tags($faq->answer), 200, '...') !!}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="btn btn-outline-primary btn-sm">Know More</a>
                                <div class="vote-actions d-flex">
                                    <button class="btn btn-light btn-sm me-2 upvote-btn" id="upvote-btn-{{ $faq->id }}" onclick="castVote({{ $faq->id }}, 'upvote')">
                                        👍 <span id="upvote-count-{{ $faq->id }}">{{$faq->up_votes}}</span>
                                    </button>
                                    <button class="btn btn-light btn-sm downvote-btn" id="downvote-btn-{{ $faq->id }}" onclick="castVote({{ $faq->id }}, 'downvote')">
                                        👎 <span id="downvote-count-{{ $faq->id }}">{{$faq->down_votes}}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="votes_error_msg votes_error_msg_{{ $faq->id }} text-danger mt-2" style="display: none;"></div>
                            </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No FAQs available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
     const askmeRoute = "{{ route('askme') }}";
     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

     document.getElementById('askForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const question = document.getElementById('question').value.trim();
    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const answerDiv = document.getElementById('answer');
    const errorDiv = document.getElementById('error');

    // Clear previous feedback
    answerDiv.style.display = 'none';
    errorDiv.style.display = 'none';

    if (!question) {
        errorDiv.style.display = 'block';
        errorDiv.textContent = 'Please enter a question before submitting.';
        return;
    }

    // Show loading spinner and disable button
    loadingSpinner.style.display = 'inline-block';
    submitButton.disabled = true;

    fetch(askmeRoute, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ question }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            loadingSpinner.style.display = 'none';
            submitButton.disabled = false;

            if (data.answer) {
                answerDiv.style.display = 'block';
                answerDiv.innerHTML = `Answer: ${data.answer}`;
                document.getElementById('question').value = ''; // Clear the question field
            } else {
                throw new Error('No answer returned.');
            }
        })
        .catch((error) => {
            loadingSpinner.style.display = 'none';
            submitButton.disabled = false;

            errorDiv.style.display = 'block';
            errorDiv.textContent = 'An error occurred. Please try again.';
            console.error('Error:', error);
        });
});

    function castVote(faqId, voteType) {
    const localStorageKey = `faq-vote-${faqId}`;
    const existingVote = localStorage.getItem(localStorageKey);
    const errorMsgElement = document.querySelector(`.votes_error_msg_${faqId}`);
    if (existingVote === voteType) {
        errorMsgElement.style.display = 'block';
        errorMsgElement.textContent = "You have already cast this vote!";
        return;
    } else if (existingVote) {
        errorMsgElement.style.display = 'none';
    }
    const upvoteBtn = document.getElementById(`upvote-btn-${faqId}`);
    const downvoteBtn = document.getElementById(`downvote-btn-${faqId}`);
    const upvoteCount = document.getElementById(`upvote-count-${faqId}`);
    const downvoteCount = document.getElementById(`downvote-count-${faqId}`);
    if (voteType === 'upvote') {
        upvoteBtn.classList.add('active');
        downvoteBtn.classList.remove('active');
        upvoteCount.textContent = parseInt(upvoteCount.textContent) + 1;
        if (existingVote === 'downvote') {
            downvoteCount.textContent = parseInt(downvoteCount.textContent) - 1;
        }
    } else if (voteType === 'downvote') {
        downvoteBtn.classList.add('active');
        upvoteBtn.classList.remove('active');
        downvoteCount.textContent = parseInt(downvoteCount.textContent) + 1;
        if (existingVote === 'upvote') {
            upvoteCount.textContent = parseInt(upvoteCount.textContent) - 1;
        }
    }
    localStorage.setItem(localStorageKey, voteType);
    fetch('/cast-vote', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            faq_id: faqId,
            vote_type: voteType,
        }),
    }).catch((error) => {
        console.error("Error submitting vote:", error);
        alert("Something went wrong. Please try again!");
    });
}

</script>
@endsection

