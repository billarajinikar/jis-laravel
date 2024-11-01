@extends('layouts.app')

@section('title', $job['headline'])

@section('content')
    <div class="mt-4 mb-5">
        <div class="card mb-5">
            <div class="card-header">
                <h1 class="card-title" style="color: #ff5722;">{{ $job['headline'] }}</h1>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-0">{{ $job['employer']['name'] }}, {{ $job['workplace_address']['municipality'] }}</p>
                </div>
                <span class="position-absolute top-0 end-0 m-3">
                            <a href="#" class="favorite-icon" style="color:#808080" data-job-id="">
                                <i class="fas fa-heart"></i>
                            </a>
                        </span>
            </div>
            <div class="card-body">
                <img src="{{ $job['logo_url'] ?? 'https://via.placeholder.com/150' }}" class="img-fluid mb-0" alt="{{ $job['headline'] }}">
                <div class="job-description">
                    {!! $job['description']['text_formatted'] !!}
                </div>
                <div class="mt-4">
                    <h5>Details:</h5>
                    <p><strong>Number of Vacancies:</strong> {{ $job['number_of_vacancies'] }}</p>
                    <p><strong>Employment Type:</strong> {{ $job['employment_type']['label'] }}</p>
                    <p><strong>Working Hours:</strong> {{ $job['working_hours_type']['label'] }}</p>
                    <p><strong>Duration:</strong> {{ $job['duration']['label'] }}</p>
                    <p><strong>Salary:</strong> {{ $job['salary_type']['label'] }}</p>
                </div>
                <?php
                $content ="";
                $applicationArr = $job["application_details"];
                $applicationInformation = $applicationArr["information"];
                $applicationEmail = $applicationArr["email"];
                $applicationURL = $applicationArr["url"];
                $jobDeadLine = date_create($job["application_deadline"]);
                $jobDeadLine = date_format($jobDeadLine, "l, F jS, Y g:i a");
                if ($applicationEmail != null) {
                    $content .=
                        "Send Email to: <a href='mail-to:{$applicationEmail}'>{$applicationEmail}</a> send your application before " .
                        $jobDeadLine .
                        "<br><br>";
                }
                if ($applicationURL != null) {
                    $content .=
                        "Apply through: <a href='$applicationURL' target='_blank'>$applicationURL</a> apply before " .
                        $jobDeadLine;
                }
                echo $content;
                ?>
                <!-- <a target="_blank" href="{{ $job['webpage_url'] }}" class="btn btn-primary mt-3">Apply here</a> -->
            </div>
            <div class="card-footer text-muted">
                <p>Published on: {{ \Carbon\Carbon::parse($job['publication_date'])->format('d M Y') }}</p>
                <p>Application Deadline: {{ \Carbon\Carbon::parse($job['application_deadline'])->format('d M Y') }}</p>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-6">
            @include('blog.titles', ['posts' => $posts])
        </div>
            <div class="col-md-6">@include('sections.similarjobs', ['similarJobs' => $similarJobs])</div>
        </div>
    </div>
@endsection
