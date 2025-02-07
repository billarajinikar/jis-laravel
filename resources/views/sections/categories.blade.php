<div class="container my-5">
    
    <div class="row">
        @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card category-card border-0 shadow-sm">
                    <div class="position-relative">
                        <a href="{{ $category['link'] }}">
                            <img loading="lazy" src="{{ asset($category['image']) }}" class="card-img-top" alt="{{ $category['name'] }}">
                            <div class="category-overlay">
                                <h4 class="category-title">{{ $category['name'] }} ({{ $category['total_jobs'] ?? "" }})</h4>
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
        height: 160px;
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
