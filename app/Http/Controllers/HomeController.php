<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPost = Post::published()->featured()->latest()->first();

        $latestPostsQuery = Post::published()->latest();
        if ($featuredPost) {
            $latestPostsQuery->where('id', '!=', $featuredPost->id);
        }
        $latestPosts = $latestPostsQuery->take(3)->get();

        $upcomingEvents = Event::upcoming()->take(5)->get();

        return view('home', compact('featuredPost', 'latestPosts', 'upcomingEvents'));
    }
}
