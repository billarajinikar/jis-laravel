@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blog Posts</h1>
        @if($posts->count())
            <div class="list-group">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="list-group-item list-group-item-action">
                        <h2>{{ $post->title }}</h2>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}</p>
                        <small>Published on: {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : 'N/A' }}</small>
                    </a>
                @endforeach
            </div>
        @else
            <p>No posts available.</p>
        @endif
    </div>
@endsection