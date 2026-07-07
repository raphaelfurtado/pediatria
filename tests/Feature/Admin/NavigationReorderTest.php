<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Navigation\Index as NavIndex;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NavigationReorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_move_down_swaps_with_next_sibling(): void
    {
        $admin = User::factory()->admin()->create();
        $a = MenuItem::factory()->create(['label' => 'A', 'order' => 0]);
        $b = MenuItem::factory()->create(['label' => 'B', 'order' => 1]);

        $this->actingAs($admin);
        Livewire::test(NavIndex::class)->call('moveDown', $a->id);

        $this->assertSame(1, $a->fresh()->order);
        $this->assertSame(0, $b->fresh()->order);
    }

    public function test_move_up_swaps_with_previous_sibling(): void
    {
        $admin = User::factory()->admin()->create();
        $a = MenuItem::factory()->create(['label' => 'A', 'order' => 0]);
        $b = MenuItem::factory()->create(['label' => 'B', 'order' => 1]);

        $this->actingAs($admin);
        Livewire::test(NavIndex::class)->call('moveUp', $b->id);

        $this->assertSame(1, $a->fresh()->order);
        $this->assertSame(0, $b->fresh()->order);
    }

    public function test_moving_first_item_up_is_a_noop(): void
    {
        $admin = User::factory()->admin()->create();
        $a = MenuItem::factory()->create(['label' => 'A', 'order' => 0]);
        $b = MenuItem::factory()->create(['label' => 'B', 'order' => 1]);

        $this->actingAs($admin);
        Livewire::test(NavIndex::class)->call('moveUp', $a->id);

        $this->assertSame(0, $a->fresh()->order);
        $this->assertSame(1, $b->fresh()->order);
    }
}
