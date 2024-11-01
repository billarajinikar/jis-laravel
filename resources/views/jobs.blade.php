@extends('layouts.app')

@section('title', 'English speaking Jobs in Stockholm, Göteborg, Malmö')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="text-center mb-5">
            <h1 class="display-4">{{$pageTitle}}</h1>
            <p class="lead">{{$pageDescription}}</div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($jobs as $job)
                <?php 
                    $jobId = $job["id"];
                    $jobLogoUrl = $job["logo_url"];
                    $jobTitle = $job["headline"];
                    $jobDescriptionArr = $job["description"];
                    $jobDescriptionFormat = $jobDescriptionArr["text_formatted"];
                    $employerArr = $job["employer"];
                    $employerName = $employerArr["name"];
                    $workPlaceAddr = $job["workplace_address"];
                    $municipality = $workPlaceAddr["municipality"];
                    $listDesciption = strip_tags($jobDescriptionFormat);
                    $listDesciption = mb_substr($listDesciption, 0, 200);
                    $pos = strrpos($listDesciption, " ", 0);
                    $listDesciption = substr($listDesciption, 0, $pos);
                    $urlTitle = preg_replace("~[^\pL\d]+~u", "-", $jobTitle);
                    $jobInfoUrl = "/job/" . $urlTitle . "/" . $jobId."/";
                    $cityUrl = "/city/" . $municipality."/";
                ?>
                <div class="col">
                    <div class="card h-100 shadow-sm position-relative">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                                <img src="{{ $job['logo_url'] ?? 'https://via.placeholder.com/150' }}" class="img-fluid rounded-start p-3" alt="{{ $jobTitle }}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title" ><a href="{{ $jobInfoUrl }}" style="color: #ff5722;">{{ $jobTitle }}</a></h5>
                                    <p class="card-text">{{ $listDesciption }}...</p>
                                    <p class="card-text"><small class="text-muted">{{ $employerName }} - <a href="{{ $cityUrl }}" class="text-decoration-none">{{ $municipality }}</a></small></p>
                                    <a href="{{ $jobInfoUrl }}" class="btn btn-primary btn-sm mt-auto align-self-start">Read More</a>
                                </div>
                            </div>
                        </div>
                        <!-- Favorite Icon -->
                        <span class="position-absolute top-0 end-0 m-3">
                            <a href="#" class="favorite-icon" style="color:#808080" data-job-id="{{ $jobId }}">
                                <i class="fas fa-heart"></i>
                            </a>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if($page > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ route('jobList', ['slug' => $slug, 'page' => $page - 1]) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif
                    @if($page > 3)
                        <li class="page-item">
                            <a class="page-link" href="{{ route('jobList', ['slug' => $slug, 'page' => 1]) }}">1</a>
                        </li>
                        @if($page > 4)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif
                    @for($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++)
                        <li class="page-item {{ $i == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ route('jobList', ['slug' => $slug, 'page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if($page < $totalPages - 2)
                        @if($page < $totalPages - 3)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ route('jobList', ['slug' => $slug, 'page' => $totalPages]) }}">{{ $totalPages }}</a>
                        </li>
                    @endif
                    @if($page < $totalPages)
                        <li class="page-item">
                            <a class="page-link" href="{{ route('jobList', ['slug' => $slug, 'page' => $page + 1]) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>


        
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favoriteIcons = document.querySelectorAll('.favorite-icon');
            favoriteIcons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.preventDefault();
                    const jobId = this.getAttribute('data-job-id');
                    
                    // Toggle the favorite state (for demonstration purposes, it just toggles class)
                    this.querySelector('i').classList.toggle('fas');
                    this.querySelector('i').classList.toggle('far');
                    
                    // You can add an AJAX request here to save/remove the favorite job in your backend
                    console.log('Job favorited:', jobId);
                });
            });
        });
    </script>
@endsection
