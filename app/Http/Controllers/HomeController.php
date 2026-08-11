<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Publication;
use App\Models\ServiceCard;
use App\Models\Slide;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('is_active', true)->orderBy('order')->get();
        $serviceCards = ServiceCard::where('is_active', true)->orderBy('order')->get();
        // Card grande = post marcado como "Destaque na Home" (mais recente);
        // se nenhum estiver marcado, cai para a notícia publicada mais recente.
        $featuredPost = Post::published()->featured()->latest('published_at')->first()
            ?? Post::published()->latest('published_at')->first();

        $latestPosts = Post::published()
            ->when($featuredPost, fn ($q) => $q->where('id', '!=', $featuredPost->id))
            ->latest('published_at')
            ->take(3)
            ->get();

        $upcomingEvents = Event::where('date_start', '>=', now())
            ->orderByDesc('is_featured')
            ->orderBy('date_start')
            ->take(5)
            ->get();
        $publications = Publication::orderBy('order')->orderBy('id')->take(4)->get();
        $featuredVideos = Video::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact(
            'slides',
            'serviceCards',
            'featuredPost',
            'latestPosts',
            'upcomingEvents',
            'publications',
            'featuredVideos',
        ));
    }
}
