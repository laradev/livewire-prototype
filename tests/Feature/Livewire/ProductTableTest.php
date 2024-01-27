<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ProductTable;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ProductTable::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_exists_on_the_page()
    {
        $this->get('/livewire')
            ->assertSeeLivewire(ProductTable::class);

    }

    /** @test */
    public function it_should_only_render_50_products()
    {
        Product::factory()->count(100)->create();
        Livewire::test(ProductTable::class)
            ->assertViewHas('products', function ($products) {
                return count($products) == 50;
            });
    }

    /** @test */
    public function it_should_filter_the_products_name()
    {
        Product::factory()->create([
            'name' => 'Eminem - The Slim Shady LP',
        ]);

        Product::factory()->create([
            'name' => 'Ray Charles - Hallelujah I Love Her So',
        ]);

        Livewire::test(ProductTable::class)
            ->set('search', 'Eminem')
            ->assertSee('Eminem')
            ->assertDontSee('Ray Charles');
    }
}
