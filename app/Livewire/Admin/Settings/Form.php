<?php

namespace App\Livewire\Admin\Settings;

use App\Models\SiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{
    public $facebook;

    public $instagram;

    public $twitter;

    public $whatsapp;

    public $contact_email;

    public $contact_phone;

    public $head_scripts;

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
        $this->contact_email = SiteSetting::get('contact_email', 'atendimento.sopape@gmail.com');
        $this->contact_phone = SiteSetting::get('contact_phone', '(91) 99999-9999');
        $this->head_scripts = SiteSetting::get('head_scripts');
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
        SiteSetting::set('contact_email', $this->contact_email);
        SiteSetting::set('contact_phone', $this->contact_phone);
        SiteSetting::set('head_scripts', $this->head_scripts);
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
