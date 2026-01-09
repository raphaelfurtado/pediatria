<?php

namespace App\Livewire\Admin\Slides;

use App\Models\Slide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Form extends Component
{
    use WithFileUploads;

    public $slideId;
    public $title;
    public $subtitle;
    public $button_text;
    public $button_link;
    public $order = 0;
    public $is_active = true;
    public $image;
    public $existingImage;

    public function mount($id = null)
    {
        if ($id) {
            $slide = Slide::findOrFail($id);
            $this->slideId = $slide->id;
            $this->title = $slide->title;
            $this->subtitle = $slide->subtitle;
            $this->button_text = $slide->button_text;
            $this->button_link = $slide->button_link;
            $this->order = $slide->order;
            $this->is_active = (bool) $slide->is_active;
            $this->existingImage = $slide->image_path;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'image' => $this->slideId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'order' => 'required|integer',
        ]);

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $path = $this->image->store('slides', 'public');
            $data['image_path'] = $path;
        }

        if ($this->slideId) {
            $slide = Slide::find($this->slideId);
            $slide->update($data);
            session()->flash('notify', 'Banner atualizado com sucesso!');
        } else {
            Slide::create($data);
            session()->flash('notify', 'Banner criado com sucesso!');
        }

        return redirect()->route('admin.slides.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.slides.form');
    }
}
