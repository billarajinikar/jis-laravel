@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Blog Posts</h1>
        @if($posts->count())
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($posts as $post)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('blog.show', $post->slug) }}" class="post-title-link">
                                    <h4 class="card-title mb-3">{{ $post->title }}</h4>
                                </a>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}</p>
                                <div class="mt-auto">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                Published on: {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No posts available.</p>
        @endif
    </div>

    <style>
        .post-title-link {
            text-decoration: none;
            color: #343a40;
            transition: color 0.3s ease;
        }

        .post-title-link:hover {
            color: #007bff;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
@endsection
