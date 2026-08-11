<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Renderiza uma página dinâmica criada no admin (/institucional/{slug}).
     */
    public function dynamic($slug)
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        return view('pages.dynamic', compact('page'));
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }
}
