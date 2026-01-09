<?php

namespace App\Livewire\Admin\Publications;

use App\Models\Publication;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public $publicationId;
    public $title;
    public $slug;
    public $description;
    public $type = 'livro';
    public $year;
    public $external_link;
    public $cover;
    public $file;
    public $existingCover;
    public $existingFile;

    public function mount($id = null)
    {
        if ($id) {
            $publication = Publication::findOrFail($id);
            $this->publicationId = $publication->id;
            $this->title = $publication->title;
            $this->slug = $publication->slug;
            $this->description = $publication->description;
            $this->type = $publication->type;
            $this->year = $publication->year;
            $this->external_link = $publication->external_link;
            $this->existingCover = $publication->cover_image;
            $this->existingFile = $publication->file_path;
        }
    }

    public function updatedTitle($value)
    {
        if (!$this->publicationId) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:publications,slug,' . $this->publicationId,
            'type' => 'required|string',
            'cover' => $this->publicationId ? 'nullable|image|max:2048' : 'nullable|image|max:2048',
            'file' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'year' => $this->year,
            'external_link' => $this->external_link,
        ];

        if ($this->cover) {
            $path = $this->cover->store('publications/covers', 'public');
            $data['cover_image'] = '/storage/' . $path;
        }

        if ($this->file) {
            $path = $this->file->store('publications/files', 'public');
            $data['file_path'] = '/storage/' . $path;
        }

        if ($this->publicationId) {
            $publication = Publication::find($this->publicationId);
            $publication->update($data);
            session()->flash('notify', 'Publicação atualizada com sucesso!');
        } else {
            Publication::create($data);
            session()->flash('notify', 'Publicação criada com sucesso!');
        }

        return redirect()->route('admin.publications.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.publications.form');
    }
}
