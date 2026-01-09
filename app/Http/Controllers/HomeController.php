<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;
use App\Models\Slide;
use App\Models\Publication;

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

        return view('home', compact('slides', 'featuredPost', 'latestPosts', 'upcomingEvents', 'publications'));
    }
}
