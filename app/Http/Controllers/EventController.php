<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::upcoming()->paginate(6);
        $pastEvents = Event::where('date_start', '<', now())->latest('date_start')->take(4)->get();
        return view('events.index', compact('upcomingEvents', 'pastEvents'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        return view('events.show', compact('event')); // Future implementation
    }
}
