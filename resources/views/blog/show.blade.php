@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p><small>Author: {{ $post->author }} | Published on: {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : 'N/A' }}</small></p>
        <div class="content">
            {!! $post->content !!}
        </div>
        <a href="{{ route('blog') }}" class="btn btn-primary">Back to Blog</a>
    </div>
@endsection