@extends('layouts.app')
@section('title', 'My Favorite Jobs')

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="text-center">My Favorite Jobs</h1>
    <p class="text-center text-muted">Here are the jobs you have saved. Save jobs to easily apply later!</p>
    
    <!-- Container for displaying favorite jobs -->
    <div id="favorite-jobs-container" class="mt-4"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('favorite-jobs-container');
        const favoriteJobs = JSON.parse(localStorage.getItem('favorite_jobs')) || [];
        console.log('favoriteJobs'+favoriteJobs);
        if (favoriteJobs.length === 0) {
            // Show a message if no jobs are found in the cache
            container.innerHTML = `
                <div class="alert alert-info text-center" role="alert">
                    <h5>No Saved Jobs Found!</h5>
                    <p>Save jobs you’re interested in, and revisit them here when you're ready to apply.</p>
                </div>
            `;
        } else {
            // Show the list of saved jobs
            let html = '';
            favoriteJobs.forEach(job => {
                html += `
                    <div class="card mb-3 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                                <img src="${job.logo_url || 'https://via.placeholder.com/150'}" class="img-fluid p-3" alt="${job.title}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="${job.url}" style="color: #ff5722;">${job.title}</a></h5>
                                    <p class="card-text">${job.description}</p>
                                    <p class="card-text"><small class="text-muted">${job.employer_name} - ${job.municipality}</small></p>
                                    <a href="${job.url}" class="btn btn-primary btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }
    });
</script>
@endsection
