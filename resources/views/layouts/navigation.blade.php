<style>
    .navbar {
        font-size: 16px;
        font-weight: 500;
    }
    .nav-item {
        margin-left:10px;
        margin-right:10px;
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

   

.nav-link {
    color: #555 !important; /* Default text color */
    transition: color 0.3s ease;
    display: flex;
    align-items: center; /* Align icon and text vertically */
}

.nav-link i.fas.fa-heart {
    color: #dc3545 !important; /* Always red heart icon */
    margin-right: 5px; /* Add some space between the icon and text */
}

.nav-link:hover i.fas.fa-heart {
    color: #dc3545 !important; /* Prevent hover color change for the heart icon */
}

.favorites-count {
    font-size: 12px;
    background-color: #dc3545; /* Red background */
    color: white;
    border-radius: 50%;
    padding: 0 5px;
    position: absolute;
    top: 0;
    right: 0;
}

.nav-item.position-relative {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

@media (max-width: 768px) {
    .favorites-count {
        transform: translate(0, 0); /* Reset transform for mobile */
        top: -5px;
        right: -10px;
        position: relative;
    }
}
@media (max-width: 320px) {
    .favorites-count {
        transform: translate(0, 0); /* Reset transform for mobile */
        top: -5px;
        right: -10px;
        position: relative;
    }
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
                    <a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ url('/blog') }}">Blog</a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link {{ request()->is('my-favorite-jobs') ? 'active' : '' }}" href="{{ url('/my-favorite-jobs') }}">
                        <i class="fas fa-heart"></i> My Favorite Jobs
                        <span id="favorites-count" class="favorites-count d-none">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
