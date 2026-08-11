<?php

namespace Tests\Feature;

use App\Livewire\Admin\Publications\Index;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicationOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_respects_manual_order(): void
    {
        Publication::factory()->create([
            'title' => 'AAA Deveria vir depois',
            'slug' => 'aaa',
            'type' => 'revista',
            'order' => 1,
        ]);
        Publication::factory()->create([
            'title' => 'BBB Deveria vir primeiro',
            'slug' => 'bbb',
            'type' => 'revista',
            'order' => 0,
        ]);

        $this->get('/biblioteca')
            ->assertSeeInOrder(['BBB Deveria vir primeiro', 'AAA Deveria vir depois']);
    }

    public function test_admin_can_reorder_with_arrows(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $first = Publication::factory()->create(['slug' => 'first', 'order' => 0]);
        $second = Publication::factory()->create(['slug' => 'second', 'order' => 1]);

        Livewire::test(Index::class)->call('moveDown', $first->id);

        $this->assertSame(1, $first->fresh()->order);
        $this->assertSame(0, $second->fresh()->order);
    }

    public function test_new_publication_is_appended_to_the_end(): void
    {
        Publication::factory()->create(['slug' => 'existente', 'order' => 5]);

        $new = Publication::factory()->create(['slug' => 'nova']);

        $this->assertSame(6, $new->order);
    }
}
