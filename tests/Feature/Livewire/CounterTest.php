<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Counter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CounterTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Counter::class);

        $component->assertStatus(200);
    }
}
