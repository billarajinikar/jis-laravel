<?php
namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index() {
        $posts = BlogPost::orderBy('published_at', 'desc')->get();
        return view('blog.index', compact('posts'));
    }

    public function onlyBlogTitles() {
        $posts = BlogPost::orderBy('published_at', 'desc')->select('title')->get();
        return view('blog.index', compact('posts'));
    }

    public function show($slug) {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('post'));
    }
}
