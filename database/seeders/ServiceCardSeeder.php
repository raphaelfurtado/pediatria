<?php

namespace Database\Seeders;

use App\Models\ServiceCard;
use Illuminate\Database\Seeder;

class ServiceCardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            [
                'title' => 'Seja um Sócio',
                'description' => 'Benefícios exclusivos para sua carreira e acesso à comunidade.',
                'icon' => 'badge',
                'color' => 'primary',
                'link' => '#',
                'cta_text' => 'Saiba mais',
                'order' => 1,
            ],
            [
                'title' => 'Calendário Vacinal',
                'description' => 'Datas atualizadas para proteger seus pacientes e familiares.',
                'icon' => 'calendar_month',
                'color' => 'accent',
                'link' => '#',
                'cta_text' => 'Ver calendário',
                'order' => 2,
            ],
            [
                'title' => 'Cursos UNA-SUS',
                'description' => 'Educação continuada e cursos online gratuitos disponíveis.',
                'icon' => 'school',
                'color' => 'rose',
                'link' => '#',
                'cta_text' => 'Acessar cursos',
                'order' => 3,
            ],
            [
                'title' => 'Fale com Pediatra',
                'description' => 'Canal direto de comunicação para esclarecimento de dúvidas.',
                'icon' => 'chat_bubble',
                'color' => 'success',
                'link' => '#',
                'cta_text' => 'Iniciar conversa',
                'order' => 4,
            ],
        ];

        foreach ($cards as $card) {
            ServiceCard::updateOrCreate(
                ['title' => $card['title']],
                $card + ['is_active' => true],
            );
        }
    }
}
