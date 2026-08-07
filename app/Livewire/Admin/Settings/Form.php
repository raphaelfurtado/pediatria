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

    public $contact_address;

    public $map_embed_url;

    public $head_scripts;

    public $seo_description;

    public $seo_image;

    public $marketing_enabled = false;

    public $marketing_title;

    public $marketing_description;

    public $marketing_button_text;

    public $marketing_button_link;

    public $article_cta_enabled = true;

    public $article_cta_label;

    public $article_cta_title;

    public $article_cta_description;

    public $article_cta_button_text;

    public $article_cta_button_link;

    public function mount()
    {
        $this->facebook = SiteSetting::get('facebook');
        $this->instagram = SiteSetting::get('instagram');
        $this->twitter = SiteSetting::get('twitter');
        $this->whatsapp = SiteSetting::get('whatsapp');
        $this->contact_email = SiteSetting::get('contact_email', 'atendimento.sopape@gmail.com');
        $this->contact_phone = SiteSetting::get('contact_phone', '(91) 99999-9999');
        $this->contact_address = SiteSetting::get('contact_address', "Rua dos Pariquis, 2999 - A\nSala 1304, Belém - PA");
        $this->map_embed_url = SiteSetting::get('map_embed_url');
        $this->head_scripts = SiteSetting::get('head_scripts');
        $this->seo_description = SiteSetting::get('seo_description', 'Sociedade Paraense de Pediatria (SOPAPE): notícias, eventos, publicações e ações voltadas à saúde da criança e do adolescente no Pará.');
        $this->seo_image = SiteSetting::get('seo_image');
        $this->marketing_enabled = SiteSetting::get('marketing_enabled', '0') === '1';
        $this->marketing_title = SiteSetting::get('marketing_title', 'Receba novidades');
        $this->marketing_description = SiteSetting::get('marketing_description', 'Inscreva-se para receber atualizações da SOPAPE');
        $this->marketing_button_text = SiteSetting::get('marketing_button_text', 'Inscrever-se');
        $this->marketing_button_link = SiteSetting::get('marketing_button_link', '#');

        $this->article_cta_enabled = SiteSetting::get('article_cta_enabled', '1') !== '0';
        $this->article_cta_label = SiteSetting::get('article_cta_label', 'Oportunidade');
        $this->article_cta_title = SiteSetting::get('article_cta_title', 'Quer publicar seu artigo?');
        $this->article_cta_description = SiteSetting::get('article_cta_description', 'A Revista SOPAPE está com edital aberto para submissão de artigos científicos.');
        $this->article_cta_button_text = SiteSetting::get('article_cta_button_text', 'Submeter Artigo');
        $this->article_cta_button_link = SiteSetting::get('article_cta_button_link', '#');
    }

    public function save()
    {
        SiteSetting::set('facebook', $this->facebook);
        SiteSetting::set('instagram', $this->instagram);
        SiteSetting::set('twitter', $this->twitter);
        SiteSetting::set('whatsapp', $this->whatsapp);
        SiteSetting::set('contact_email', $this->contact_email);
        SiteSetting::set('contact_phone', $this->contact_phone);
        SiteSetting::set('contact_address', $this->contact_address);
        SiteSetting::set('map_embed_url', $this->normalizeMapUrl($this->map_embed_url));
        SiteSetting::set('head_scripts', $this->head_scripts);
        SiteSetting::set('seo_description', $this->seo_description);
        SiteSetting::set('seo_image', $this->seo_image);
        SiteSetting::set('marketing_enabled', $this->marketing_enabled ? '1' : '0');
        SiteSetting::set('marketing_title', $this->marketing_title);
        SiteSetting::set('marketing_description', $this->marketing_description);
        SiteSetting::set('marketing_button_text', $this->marketing_button_text);
        SiteSetting::set('marketing_button_link', $this->marketing_button_link);

        SiteSetting::set('article_cta_enabled', $this->article_cta_enabled ? '1' : '0');
        SiteSetting::set('article_cta_label', $this->article_cta_label);
        SiteSetting::set('article_cta_title', $this->article_cta_title);
        SiteSetting::set('article_cta_description', $this->article_cta_description);
        SiteSetting::set('article_cta_button_text', $this->article_cta_button_text);
        SiteSetting::set('article_cta_button_link', $this->article_cta_button_link);

        session()->flash('notify', 'Configurações atualizadas com sucesso!');
    }

    /**
     * Aceita a URL de incorporação OU o código <iframe> inteiro do Google Maps,
     * extrai o src e só mantém se for de fato um embed do Google Maps (segurança).
     */
    protected function normalizeMapUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (preg_match('/src="([^"]+)"/i', $value, $m)) {
            $value = $m[1];
        }

        if (! preg_match('~^https://(www\.google\.com/maps/embed|maps\.google\.com/maps)~i', $value)) {
            return null;
        }

        return $value;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.settings.form');
    }
}
