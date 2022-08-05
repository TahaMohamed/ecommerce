<?php

namespace Tests\Feature;

use App\Models\{Store, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProductTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_merchant_add_product()
    {
        $user = User::factory()->create();
        Store::factory()->for($user,'merchant')->create();
        $this->actingAs($user)
            ->withoutExceptionHandling()
            ->postJson('api/merchant/products', $this->getProductData())
            ->assertStatus(201);
    }

    private function getProductData()
    {
        $product_data = [];
        foreach (config('translatable.locales') as $locale) {
            $product_data +=[
                $locale => [
                    'name' => fake()->name(),
                    'description' => fake()->paragraph(2)
                ],
                'is_active' => true,
                'price' => 200
            ];
        }
        return $product_data;
    }
}
