<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_unknown_route_renders_branded_404(): void
    {
        $response = $this->get('/uma-rota-que-nao-existe-'.uniqid());

        $response->assertNotFound();
        $response->assertSee('Página não encontrada');
        $response->assertSee('SOPAPE');
    }

    /**
     * @dataProvider errorCodeProvider
     */
    public function test_error_view_renders_with_branding(string $code, string $title): void
    {
        $html = view("errors.{$code}")->render();

        $this->assertStringContainsString($code, $html);
        $this->assertStringContainsString($title, $html);
        $this->assertStringContainsString('SOPAPE', $html);
    }

    public static function errorCodeProvider(): array
    {
        return [
            '403' => ['403', 'Acesso negado'],
            '404' => ['404', 'Página não encontrada'],
            '419' => ['419', 'Sessão expirada'],
            '429' => ['429', 'Muitas tentativas'],
            '500' => ['500', 'Erro interno'],
            '503' => ['503', 'Em manutenção'],
        ];
    }
}
