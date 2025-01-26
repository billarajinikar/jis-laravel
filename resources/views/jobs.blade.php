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
            @foreach ($jobs as $index => $job)
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
                <!-- Inject Google Ad after the 2nd and 5th job cards -->
                @if($index === 2 || $index === 6)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <!-- Google Ads Code -->
                                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8349643691635774"
                                    crossorigin="anonymous"></script>
                                <ins class="adsbygoogle"
                                    style="display:block"
                                    data-ad-format="fluid"
                                    data-ad-layout-key="-f6+3e+bp-9k-bu"
                                    data-ad-client="ca-pub-8349643691635774"
                                    data-ad-slot="1099685050"></ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Job Card -->
                <div class="col">
                    <div class="card h-100 shadow-sm position-relative">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                                <img id="{{$jobId}}" src="{{ $job['logo_url'] ?? 'https://via.placeholder.com/150' }}" class="img-fluid rounded-start p-3" alt="{{ $jobTitle }}" loading="lazy">
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
                    <script type="application/ld+json">
                        {
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [
                            @for ($i = 1; $i <= $totalPages; $i++)
                            {
                            "@type": "ListItem",
                            "position": {{ $i }},
                            "name": "Page {{ $i }}",
                            "item": "{{ route($route, ['slug' => $slug, 'page' => $i]) }}"
                            }{{ $i < $totalPages ? ',' : '' }}
                            @endfor
                        ]
                        }
                    </script>

                    @if($page > 1)
                        <li class="page-item">
                            <a rel="prev" class="page-link" href="{{ route($route, ['slug' => $slug, 'page' => $page - 1]) }}" aria-label="Previous">
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
                            <a rel="next" class="page-link" href="{{ route($route, ['slug' => $slug, 'page' => $page + 1]) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endsection
