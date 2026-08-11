<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

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

    public $tags;

    public $is_featured = false;

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
            $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : null;
            $this->existingImage = $post->image_path;
            $this->tags = $post->tags;
            $this->is_featured = (bool) $post->is_featured;
        } else {
            $this->published_at = now()->format('Y-m-d\TH:i');
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->postId) {
            $this->slug = Str::slug($value);
        }
    }

    /**
     * Regenera o slug a partir do título (usado pelo botão, já que o campo é somente-leitura).
     */
    public function regenerateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save($exit = false)
    {
        // Garante que o slug seja sempre um slug válido (nunca uma URL).
        $this->slug = Str::slug($this->slug);

        $this->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug,'.$this->postId,
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
            'tags' => $this->tags,
            'is_featured' => (bool) $this->is_featured,
            'published_at' => $this->status === 'published' ? $this->published_at : null,
        ];

        // Only set author on creation
        if (! $this->postId) {
            $data['author_id'] = auth()->id();
        }

        if ($this->image) {
            $path = \App\Services\ImageOptimizer::store($this->image, 'posts');
            $data['image_path'] = '/storage/'.$path;
        }

        if ($this->postId) {
            $post = Post::find($this->postId);
            $post->update($data);
            $message = 'Notícia salva com sucesso!';
        } else {
            $post = Post::create($data);
            $message = 'Notícia criada com sucesso!';
        }

        // "Salvar e voltar à lista"
        if ($exit) {
            session()->flash('notify', $message);

            return redirect()->route('admin.posts.index');
        }

        // Recém-criada: entra no modo de edição para continuar na mesma página.
        if (! $this->postId) {
            session()->flash('notify', $message.' Continue editando.');

            return redirect()->route('admin.posts.edit', $post->id);
        }

        // Edição: permanece na página, atualiza o preview da imagem e avisa.
        if ($this->image) {
            $this->existingImage = $data['image_path'];
            $this->image = null;
        }
        $this->dispatch('notify', $message);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.posts.form');
    }
}
