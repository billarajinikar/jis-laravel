<style>
    .navbar {
    font-size: 16px;
    font-weight: 500;
}

.nav-link {
    color: #555 !important; /* Default text color */
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #007bff !important; /* Change text color on hover */
}

.nav-link.active {
    color: #007bff !important; /* Highlight active link */
    font-weight: bold;
    border-bottom: 2px solid #007bff; /* Optional underline for active link */
}

</style>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Logo aligned to the left -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/Logo_JobsinSweden.png') }}" alt="Jobs in Sweden Logo" class="img-fluid" style="height: 50px;">
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('find-a-job-in-sweden') ? 'active' : '' }}" href="{{ url('/find-a-job-in-sweden') }}">Find a Job</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('ask-me') ? 'active' : '' }}" href="{{ url('/ask-me') }}">Ask Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ url('/blog') }}">Blog</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
