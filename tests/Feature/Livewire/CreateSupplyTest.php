<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateSupply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateSupplyTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(CreateSupply::class)
            ->assertStatus(200);
    }
}
