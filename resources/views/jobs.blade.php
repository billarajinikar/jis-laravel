@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <div class="container mt-4 mb-5">
        <div class="text-center mb-4">
            <h1 class="display-4">{{$pageHeadding}}</h1>
            <p class="lead">{{$pageDescription}}       
        </div>
        @include('sections.searchbox', ['cities' => $cities])
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
                                <img id="{{$jobId}}" src="{{ $job['logo_url'] ?? 'https://via.placeholder.com/150' }}" class="img-fluid rounded-start p-3" alt="{{ $jobTitle }}">
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
                        <!-- Favorite Icon -->
<span class="position-absolute top-0 end-0 m-3">
    <a href="#" class="favorite-icon" style="color:#ff5722" 
        data-job-id="{{ $jobId }}"
        data-job-title ="{{$jobTitle}}"
        data-job-description ="{{$listDesciption}}"
        data-job-employer-name ="{{$employerName}}"
        data-job-municipality ="{{$municipality}}"
    >
        <i class="far fa-heart"></i> <!-- Start with the "far" class -->
    </a>
</span>

                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php 
                        $route = ($pageType==='cat') ?'jobList':'jobListCity';
                    ?>
                    @if($page > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ route($route, ['slug' => $slug, 'page' => $page - 1]) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif
                    @if($page > 3)
                        <li class="page-item">
                            <a class="page-link" href="{{ route($route, ['slug' => $slug, 'page' => 1]) }}">1</a>
                        </li>
                        @if($page > 4)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif
                    @for($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++)
                        <li class="page-item {{ $i == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ route($route, ['slug' => $slug, 'page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if($page < $totalPages - 2)
                        @if($page < $totalPages - 3)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ route($route, ['slug' => $slug, 'page' => $totalPages]) }}">{{ $totalPages }}</a>
                        </li>
                    @endif
                    @if($page < $totalPages)
                        <li class="page-item">
                            <a class="page-link" href="{{ route($route, ['slug' => $slug, 'page' => $page + 1]) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const favoriteIcons = document.querySelectorAll('.favorite-icon');

        // Retrieve the existing favorite jobs from localStorage
        let favoriteJobs = JSON.parse(localStorage.getItem('favorite_jobs')) || [];

        // Initialize the icon state based on the saved jobs in localStorage
        favoriteIcons.forEach(icon => {
            console.log('Hello2');

            const jobId = icon.getAttribute('data-job-id');
            const iconElement = icon.querySelector('i'); // Get the <i> element inside the favorite-icon

            // Check if the job is already saved in localStorage
            if (favoriteJobs.some(job => job.id === jobId)) {
                iconElement.classList.add('fas'); // Filled heart
                iconElement.classList.remove('far'); // Empty heart
            } else {
                iconElement.classList.add('far'); // Empty heart
                iconElement.classList.remove('fas'); // Filled heart
            }

            // Add click event listener for toggling the favorite state
            icon.addEventListener('click', function (e) {
                e.preventDefault();

                const jobTitle = icon.getAttribute('data-job-title');
                const jobDescription = icon.getAttribute('data-job-description');
                const jobEmployerName = icon.getAttribute('data-job-employer-name');
                const jobMunicipality = icon.getAttribute('data-job-municipality');
                const jobLogoElement = document.getElementById(jobId); // Select the <img> by its ID
                const jobLogoUrl = jobLogoElement ? jobLogoElement.src : 'https://via.placeholder.com/150';
                let jobTitleSlug = jobTitle
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-'); // Replace multiple hyphens with a single hyphen

                // Convert to lowercase for consistency (optional)
                jobTitleSlug = jobTitleSlug.toLowerCase();
                const jobUrl = `/job/${jobTitleSlug}/${jobId}/`;

                const jobIndex = favoriteJobs.findIndex(job => job.id === jobId);

                if (jobIndex !== -1) {
                    // Job is already in favorites, remove it
                    favoriteJobs.splice(jobIndex, 1);
                    iconElement.classList.remove('fas');
                    iconElement.classList.add('far');
                } else {
                    // Job is not in favorites, add it
                    favoriteJobs.push({
                        id: jobId,
                        title: jobTitle,
                        description: jobDescription,
                        employer_name: jobEmployerName,
                        municipality: jobMunicipality,
                        logo_url: jobLogoUrl,
                        url: jobUrl
                    });
                    iconElement.classList.remove('far');
                    iconElement.classList.add('fas');
                }

                // Update the favorite jobs in localStorage
                localStorage.setItem('favorite_jobs', JSON.stringify(favoriteJobs));

                // Debugging: Log the updated favorite jobs
                console.log('Updated Favorite Jobs:', favoriteJobs);
            });
        });
    });
</script>



