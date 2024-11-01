<div>
    <h2 class="text-center mb-4">Blog posts</h2>
    <div class="mt-4">
        <div class="container">
            @if($posts->count())
                <div class="list-group">
                    @foreach($posts as $post)
                        <a href="{{ route('blog.show', $post->slug) }}" class="list-group-item list-group-item-action" style="font-weight: bold; color: #ff6347; text-decoration: none;">
                            <p>{{ $post->title }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p>No posts available.</p>
            @endif
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('blog') }}" class="btn btn-primary">View All Posts</a>
    </div>
</div>