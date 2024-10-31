<div class="container my-5">
    <div class="row text-center">
        <h2>Explore Jobs by Location</h2>
        <p class="mb-4">Find job opportunities in your preferred city! Click on any city below to see current openings and discover the roles waiting for you. Whether you're drawn to the energy of Stockholm, the innovation in Gothenburg, or the charm of Malmö, start your search by location and find a career that fits your lifestyle.</p>
    </div>
    <div class="row">
        @foreach($cities as $city)
            <div class="col-md-3 mb-4">
                <div class="card city-card border-0 shadow-sm">
                    <div class="position-relative">
                        <a href="{{ $city['link'] }}">
                            <img src="{{ asset($city['image']) }}" class="card-img-top" alt="{{ $city['name'] }}">
                            <div class="city-overlay">
                                <h4 class="city-title">{{ $city['name'] }}</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .category-card {
        overflow: hidden;
        border-radius: 15px;
    }

    .category-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .category-card:hover img {
        transform: scale(1.05);
    }

    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        color: #ffffff;
        padding: 10px;
        text-align: center;
        transition: background 0.3s;
    }

    .category-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
    }

    .category-card:hover .category-overlay {
        background: rgba(0, 0, 0, 0.8);
    }
</style>
