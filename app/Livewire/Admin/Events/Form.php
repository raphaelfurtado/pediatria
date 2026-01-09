<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public $eventId;
    public $title;
    public $slug;
    public $description;
    public $date_start;
    public $date_end;
    public $location;
    public $type = 'presencial';
    public $registration_link;
    public $is_featured = false;
    public $image;
    public $existingImage;

    public function mount($id = null)
    {
        if ($id) {
            $event = Event::findOrFail($id);
            $this->eventId = $event->id;
            $this->title = $event->title;
            $this->slug = $event->slug;
            $this->description = $event->description;
            $this->date_start = $event->date_start ? $event->date_start->format('Y-m-d\TH:i') : null;
            $this->date_end = $event->date_end ? $event->date_end->format('Y-m-d\TH:i') : null;
            $this->location = $event->location;
            $this->type = $event->type;
            $this->registration_link = $event->registration_link;
            $this->is_featured = (bool) $event->is_featured;
            $this->existingImage = $event->image_path;
        }
    }

    public function updatedTitle($value)
    {
        if (!$this->eventId) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:events,slug,' . $this->eventId,
            'date_start' => 'required',
            'location' => 'required|string',
            'type' => 'required|in:presencial,online,hibrido',
            'image' => $this->eventId ? 'nullable|image|max:2048' : 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'location' => $this->location,
            'type' => $this->type,
            'registration_link' => $this->registration_link,
            'is_featured' => $this->is_featured,
        ];

        if ($this->image) {
            $path = $this->image->store('events', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        if ($this->eventId) {
            $event = Event::find($this->eventId);
            $event->update($data);
            session()->flash('notify', 'Evento atualizado com sucesso!');
        } else {
            Event::create($data);
            session()->flash('notify', 'Evento criado com sucesso!');
        }

        return redirect()->route('admin.events.index');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.events.form');
    }
}
