<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{
    public $pageId;

    public $title;

    public $slug;

    public $content;

    public $is_active = true;

    public function mount($id = null)
    {
        if ($id) {
            $page = Page::findOrFail($id);
            $this->pageId = $page->id;
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->content = $page->content;
            $this->is_active = (bool) $page->is_active;
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->pageId) {
            $this->slug = Str::slug($value);
        }
    }

    public function regenerateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save($exit = false)
    {
        $this->slug = Str::slug($this->slug);

        // Slugs que colidem com rotas existentes (ficariam inacessíveis).
        $reserved = [
            'admin', 'noticias', 'biblioteca', 'eventos', 'galeria', 'videos', 'sobre',
            'contato', 'login', 'esqueci-senha', 'redefinir-senha', 'area-do-socio',
            'politica-de-privacidade', 'termos-de-uso', 'feed', 'sitemap', 'robots',
            'up', 'livewire', 'storage', 'institucional',
        ];

        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'unique:pages,slug,'.$this->pageId, \Illuminate\Validation\Rule::notIn($reserved)],
        ], [
            'slug.not_in' => 'Este endereço é reservado pelo sistema. Ajuste o título/slug.',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_active' => (bool) $this->is_active,
        ];

        if ($this->pageId) {
            Page::find($this->pageId)->update($data);
            $message = 'Página salva com sucesso!';
        } else {
            $page = Page::create($data);
            $message = 'Página criada com sucesso!';
        }

        if ($exit || ! $this->pageId) {
            session()->flash('notify', $message);

            return redirect()->route('admin.pages.index');
        }

        $this->dispatch('notify', $message);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.pages.form');
    }
}
