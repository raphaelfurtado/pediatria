<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

use App\Models\SiteSetting;
use Livewire\Attributes\Layout;

class Form extends Component
{
    public $facebook;
    public $instagram;
    public $twitter;
    public $whatsapp;
    public $marketing_title;
    public $marketing_description;
    public $marketing_button_text;
    public $marketing_button_link;

    public function mount()
    {
        $this->facebook = SiteSetting::get('facebook');
        $this->instagram = SiteSetting::get('instagram');
        $this->twitter = SiteSetting::get('twitter');
        $this->whatsapp = SiteSetting::get('whatsapp');
        $this->marketing_title = SiteSetting::get('marketing_title', 'Receba novidades');
        $this->marketing_description = SiteSetting::get('marketing_description', 'Inscreva-se para receber atualizações da SOPAPE');
        $this->marketing_button_text = SiteSetting::get('marketing_button_text', 'Inscrever-se');
        $this->marketing_button_link = SiteSetting::get('marketing_button_link', '#');
    }

    public function save()
    {
        SiteSetting::set('facebook', $this->facebook);
        SiteSetting::set('instagram', $this->instagram);
        SiteSetting::set('twitter', $this->twitter);
        SiteSetting::set('whatsapp', $this->whatsapp);
        SiteSetting::set('marketing_title', $this->marketing_title);
        SiteSetting::set('marketing_description', $this->marketing_description);
        SiteSetting::set('marketing_button_text', $this->marketing_button_text);
        SiteSetting::set('marketing_button_link', $this->marketing_button_link);

        session()->flash('notify', 'Configurações atualizadas com sucesso!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.settings.form');
    }
}
