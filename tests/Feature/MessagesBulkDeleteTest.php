<?php

namespace Tests\Feature;

use App\Livewire\Admin\Messages\Index as MessagesIndex;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MessagesBulkDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    protected function makeMessage(string $name): ContactMessage
    {
        return ContactMessage::create([
            'name' => $name,
            'email' => strtolower($name).'@example.com',
            'message' => 'Mensagem de '.$name,
        ]);
    }

    public function test_deletes_only_selected_messages(): void
    {
        $spam1 = $this->makeMessage('Spam1');
        $spam2 = $this->makeMessage('Spam2');
        $real = $this->makeMessage('Real');

        Livewire::test(MessagesIndex::class)
            ->set('selected', [(string) $spam1->id, (string) $spam2->id])
            ->assertSee('Excluir selecionadas (2)')
            ->call('deleteSelected')
            ->assertSet('selected', [])
            ->assertDispatched('notify', '2 mensagens excluídas.');

        $this->assertSame([$real->id], ContactMessage::pluck('id')->all());
    }

    public function test_select_all_toggles_current_page(): void
    {
        $ids = collect(['A', 'B', 'C'])->map(fn ($n) => (string) $this->makeMessage($n)->id)->sort()->values()->all();

        $component = Livewire::test(MessagesIndex::class)->call('togglePageSelection');
        $this->assertEqualsCanonicalizing($ids, $component->get('selected'));

        $component->call('togglePageSelection')->assertSet('selected', []);
    }

    public function test_single_delete_removes_message_from_selection(): void
    {
        $a = $this->makeMessage('Aaa');
        $b = $this->makeMessage('Bbb');

        // Cenário do bug: duas marcadas e uma apagada individualmente — o contador não pode ficar em 2.
        Livewire::test(MessagesIndex::class)
            ->set('selected', [(string) $a->id, (string) $b->id])
            ->call('delete', $a->id)
            ->assertSet('selected', [(string) $b->id])
            ->assertSee('Excluir selecionadas (1)');
    }

    public function test_selection_drops_messages_that_no_longer_exist(): void
    {
        $a = $this->makeMessage('Aaa');

        Livewire::test(MessagesIndex::class)
            ->set('selected', [(string) $a->id, '999'])
            ->assertSet('selected', [(string) $a->id])
            ->assertSee('Excluir selecionadas (1)');
    }

    public function test_individual_trash_is_hidden_while_selecting(): void
    {
        $a = $this->makeMessage('Aaa');

        Livewire::test(MessagesIndex::class)
            ->assertSeeHtml('title="Excluir"')
            ->set('selected', [(string) $a->id])
            ->assertDontSeeHtml('title="Excluir"');
    }

    public function test_messages_page_renders(): void
    {
        $this->makeMessage('Fulano');

        $this->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('Selecionar todas desta página');
    }
}
