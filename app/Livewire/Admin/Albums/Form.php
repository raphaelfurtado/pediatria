<?php

namespace App\Livewire\Admin\Albums;

use App\Models\PhotoAlbum;
use App\Models\Photo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public $albumId;
    public $title;
    public $slug;
    public $description;
    public $is_active = true;
    public $cover;
    public $photos = [];
    public $existingCover;
    public $existingPhotos = [];

    public function mount($id = null)
    {
        if ($id) {
            $album = PhotoAlbum::with('photos')->findOrFail($id);
            $this->albumId = $album->id;
            $this->title = $album->title;
            $this->slug = $album->slug;
            $this->description = $album->description;
            $this->is_active = (bool) $album->is_active;
            $this->existingCover = $album->cover_image;
            $this->existingPhotos = $album->photos;
        }
    }

    public function updatedTitle($value)
    {
        if (!$this->albumId) {
            $this->slug = Str::slug($value);
        }
    }

    public function deletePhoto($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->delete();
        $this->existingPhotos = Photo::where('photo_album_id', $this->albumId)->get();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:photo_albums,slug,' . $this->albumId,
            'cover' => $this->albumId ? 'nullable|image|max:2048' : 'nullable|image|max:2048',
            'photos.*' => 'image|max:5120',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->cover) {
            $path = $this->cover->store('albums/covers', 'public');
            $data['cover_image'] = '/storage/' . $path;
        }

        if ($this->albumId) {
            $album = PhotoAlbum::find($this->albumId);
            $album->update($data);
        } else {
            $album = PhotoAlbum::create($data);
        }

        if (!empty($this->photos)) {
            foreach ($this->photos as $photoFile) {
                $path = $photoFile->store('albums/photos/' . $album->id, 'public');
                Photo::create([
                    'photo_album_id' => $album->id,
                    'image_path' => '/storage/' . $path,
                ]);
            }
        }

        session()->flash('notify', 'Álbum salvo com sucesso!');
        return redirect()->route('admin.albums.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.albums.form');
    }
}
