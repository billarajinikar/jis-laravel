@extends('layouts.app')

@section('title', e($job['headline']))

@section('content')
<div class="mt-4 mb-5">
    <div class="card mb-5">
        <div class="card-header">
            <h1 class="card-title" style="color: #ff5722;">{{ $job['headline'] }}</h1>
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">{{ $job['employer']['name'] ?? 'Unknown Employer' }}, {{ $job['workplace_address']['municipality'] ?? 'Unknown Location' }}</p>
            </div>
            <!-- Favorite Icon -->
             <?php
                $listDesciption = strip_tags($job['description']['text_formatted']);
                $listDesciption = mb_substr($listDesciption, 0, 200);
             ?>
            <span class="position-absolute top-0 end-0 m-3">
                <a href="#" class="favorite-icon" style="color:#ff5722" 
                    data-job-id="{{ $job['id'] }}"
                    data-job-title="{{ $job['headline'] }}"
                    data-job-description="{{ $listDesciption }}"
                    data-job-employer-name="{{ $job['employer']['name'] }}"
                    data-job-municipality="{{ $job['workplace_address']['municipality'] }}"
                >
                    <i class="far fa-heart"></i> <!-- Default state as empty heart -->
                </a>
            </span>
        </div>
        <div class="card-body">
            <img id="{{ $job['id'] }}" src="{{ $job['logo_url'] ?? 'https://via.placeholder.com/150' }}" class="img-fluid mb-0" alt="{{ $job['headline'] }}">
            <div class="job-description">
                {!! $job['description']['text_formatted'] !!}
            </div>
            <div class="mt-4">
                <h5>Details:</h5>
                <p><strong>Number of Vacancies:</strong> {{ $job['number_of_vacancies'] ?? 'Not specified' }}</p>
                <p><strong>Employment Type:</strong> {{ $job['employment_type']['label'] ?? 'Not specified' }}</p>
                <p><strong>Working Hours:</strong> {{ $job['working_hours_type']['label'] ?? 'Not specified' }}</p>
                <p><strong>Duration:</strong> {{ $job['duration']['label'] ?? 'Not specified' }}</p>
                <p><strong>Salary:</strong> {{ $job['salary_type']['label'] ?? 'Not specified' }}</p>
            </div>
            <div class="application-details">
                @if (!empty($job['application_details']['email']))
                    <p>Send Email to: 
                        <a href="mailto:{{ $job['application_details']['email'] }}">
                            {{ $job['application_details']['email'] }}
                        </a> before {{ \Carbon\Carbon::parse($job['application_deadline'])->format('l, F jS, Y g:i a') }}
                    </p>
                @endif
                @if (!empty($job['application_details']['url']))
                    <p>Apply through: 
                        <a href="{{ $job['application_details']['url'] }}" target="_blank">
                            {{ $job['application_details']['url'] }}
                        </a> before {{ \Carbon\Carbon::parse($job['application_deadline'])->format('l, F jS, Y g:i a') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="card-footer text-muted">
            <p>Published on: {{ \Carbon\Carbon::parse($job['publication_date'])->toFormattedDateString() }}</p>
            <p>Application Deadline: {{ \Carbon\Carbon::parse($job['application_deadline'])->toFormattedDateString() }}</p>
        </div>
    </div>
    <div class="ads-container text-center my-4">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8349643691635774"
            crossorigin="anonymous"></script>
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
    <div class="row">
        <div class="col-md-6">
            @include('blog.titles', ['posts' => $posts])
        </div>
        <div class="col-md-6">
            @include('sections.similarjobs', ['similarJobs' => $similarJobs])
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const favoriteIcon = document.querySelector('.favorite-icon');
        const jobId = favoriteIcon.getAttribute('data-job-id');
        const iconElement = favoriteIcon.querySelector('i'); // Get the <i> inside the favorite icon

        // Retrieve saved jobs from localStorage
        let favoriteJobs = JSON.parse(localStorage.getItem('favorite_jobs')) || [];

        // Check if the current job is already saved
        const isFavorite = favoriteJobs.some(job => job.id === jobId);

        // Set initial icon state based on the saved status
        if (isFavorite) {
            iconElement.classList.add('fas'); // Filled heart
            iconElement.classList.remove('far'); // Empty heart
        } else {
            iconElement.classList.add('far'); // Empty heart
            iconElement.classList.remove('fas'); // Filled heart
        }

        // Add click event to toggle favorite status
        favoriteIcon.addEventListener('click', function (e) {
            e.preventDefault();

            const jobTitle = favoriteIcon.getAttribute('data-job-title');
            const jobDescription = favoriteIcon.getAttribute('data-job-description');
            const jobEmployerName = favoriteIcon.getAttribute('data-job-employer-name');
            const jobMunicipality = favoriteIcon.getAttribute('data-job-municipality');
            const jobLogoElement = document.getElementById(jobId);
            const jobLogoUrl = jobLogoElement ? jobLogoElement.src : 'https://via.placeholder.com/150';

            // Toggle favorite status
            if (isFavorite) {
                // Remove from favorites
                favoriteJobs = favoriteJobs.filter(job => job.id !== jobId);
                iconElement.classList.remove('fas');
                iconElement.classList.add('far');
            } else {
                // Add to favorites
                favoriteJobs.push({
                    id: jobId,
                    title: jobTitle,
                    description: jobDescription,
                    employer_name: jobEmployerName,
                    municipality: jobMunicipality,
                    logo_url: jobLogoUrl
                });
                iconElement.classList.remove('far');
                iconElement.classList.add('fas');
            }

            // Update localStorage
            localStorage.setItem('favorite_jobs', JSON.stringify(favoriteJobs));

            // Toggle the `isFavorite` status
            isFavorite = !isFavorite;
        });
    });
</script>
