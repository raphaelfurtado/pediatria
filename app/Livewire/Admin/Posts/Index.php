<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        $this->dispatch('notify', 'Notícia excluída com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $posts = Post::query()
            ->with('author')
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest('published_at')
            ->paginate(10);

        return view('livewire.admin.posts.index', [
            'posts' => $posts
        ]);
    }
}
