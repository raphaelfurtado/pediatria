<?php

namespace App\Livewire\Admin\About;

use App\Models\SiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Form extends Component
{
    public $title;

    public $subtitle;

    public $content;

    public function mount()
    {
        $this->title = SiteSetting::get('about_title', 'Sobre a SOPAPE');
        $this->subtitle = SiteSetting::get('about_subtitle', 'Sociedade Paraense de Pediatria');
        $this->content = SiteSetting::get('about_content', self::defaultContent());
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        SiteSetting::set('about_title', $this->title);
        SiteSetting::set('about_subtitle', $this->subtitle);
        SiteSetting::set('about_content', $this->content);

        $this->dispatch('notify', 'Página "Sobre" atualizada com sucesso!');
    }

    /**
     * Conteúdo padrão da página Sobre (usado até o primeiro salvamento).
     */
    public static function defaultContent(): string
    {
        return <<<'HTML'
<p>A <strong>Sociedade Paraense de Pediatria (SOPAPE)</strong> é uma entidade civil sem fins lucrativos, filiada à Sociedade Brasileira de Pediatria (SBP), que congrega os médicos pediatras do estado do Pará.</p>
<h3>Missão</h3>
<p>Promover a atualização científica dos profissionais de saúde, defender os interesses da classe pediátrica e atuar em defesa da saúde e bem-estar de crianças e adolescentes.</p>
<h3>História</h3>
<p>Fundada com o objetivo de unir os pediatras paraenses, a SOPAPE tem desempenhado um papel fundamental na melhoria da assistência à saúde infantil no estado através de congressos, cursos de educação continuada e campanhas de conscientização pública.</p>
HTML;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.about.form');
    }
}
