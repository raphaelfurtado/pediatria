<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Publication;
use App\Models\Slide;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('is_active', true)->orderBy('order')->get();
        $featuredPost = Post::published()->featured()->latest()->first();

        $latestPostsQuery = Post::published()->latest();
        if ($featuredPost) {
            $latestPostsQuery->where('id', '!=', $featuredPost->id);
        }
        $latestPosts = $latestPostsQuery->take(3)->get();

        $upcomingEvents = Event::upcoming()->take(5)->get();
        $publications = Publication::latest()->take(4)->get();
        $featuredVideos = Video::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact(
            'slides',
            'featuredPost',
            'latestPosts',
            'upcomingEvents',
            'publications',
            'featuredVideos',
        ));
    }
}
