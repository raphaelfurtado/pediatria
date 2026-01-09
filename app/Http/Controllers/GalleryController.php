<?php

namespace App\Http\Controllers;

use App\Models\PhotoAlbum;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = PhotoAlbum::withCount('photos')->latest()->paginate(12);
        return view('gallery.index', compact('albums'));
    }

    public function show($id)
    {
        $album = PhotoAlbum::with('photos')->findOrFail($id);
        return view('gallery.show', compact('album'));
    }
}