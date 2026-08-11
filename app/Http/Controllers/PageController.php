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
     * Renderiza uma página dinâmica criada no admin, na raiz (/{slug}).
     * Resiliente: se a tabela ainda não existir, responde 404 em vez de 500.
     */
    public function dynamic($slug)
    {
        $page = \Illuminate\Support\Facades\Schema::hasTable('pages')
            ? Page::active()->where('slug', $slug)->first()
            : null;

        abort_if(! $page, 404);

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
