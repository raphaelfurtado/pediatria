<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public $postId;
    public $title;
    public $slug;
    public $excerpt;
    public $content;
    public $category;
    public $status = 'draft';
    public $published_at;
    public $image;
    public $existingImage;

    public function mount($id = null)
    {
        if ($id) {
            $post = Post::findOrFail($id);
            $this->postId = $post->id;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt;
            $this->content = $post->content;
            $this->category = $post->category;
            $this->status = $post->published_at ? 'published' : 'draft';
            $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d') : null;
            $this->existingImage = $post->image_path;
        } else {
            $this->published_at = now()->format('Y-m-d');
        }
    }

    public function updatedTitle($value)
    {
        if (!$this->postId) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug,' . $this->postId,
            'content' => 'required',
            'category' => 'required',
            'published_at' => 'required_if:status,published',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category,
            'published_at' => $this->status === 'published' ? $this->published_at : null,
        ];

        // Only set author on creation
        if (!$this->postId) {
            $data['author_id'] = auth()->id();
        }

        if ($this->image) {
            $path = $this->image->store('posts', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        if ($this->postId) {
            $post = Post::find($this->postId);
            $post->update($data);
            session()->flash('notify', 'Notícia atualizada com sucesso!');
        } else {
            Post::create($data);
            session()->flash('notify', 'Notícia criada com sucesso!');
        }

        return redirect()->route('admin.posts.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.posts.form');
    }
}
