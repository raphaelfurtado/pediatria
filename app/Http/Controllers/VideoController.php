<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('is_active', true)
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(12);

        return view('videos.index', compact('videos'));
    }
}
