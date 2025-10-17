<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = Post::published()
            ->byType('berita')
            ->latest('published_at')
            ->take(6)
            ->get();

        $announcements = Post::published()
            ->byType('pengumuman')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Services disabled - no longer using services database
        $services = collect(); // Empty collection

        return view('home', compact('latestNews', 'announcements', 'services'));
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        // Services disabled - no longer using services database
        $services = collect(); // Empty collection
        return view('services', compact('services'));
    }

    public function news()
    {
        $news = Post::published()
            ->byType('berita')
            ->latest('published_at')
            ->paginate(12);

        return view('news', compact('news'));
    }

    public function announcements()
    {
        $announcements = Post::published()
            ->byType('pengumuman')
            ->latest('published_at')
            ->paginate(12);

        return view('announcements', compact('announcements'));
    }


    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $post->increment('views');

        $relatedPosts = Post::published()
            ->byType($post->type)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('post-detail', compact('post', 'relatedPosts'));
    }

}
