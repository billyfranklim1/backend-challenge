<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Support\Str;

class SaveProductTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    private Product $product;
    const SAVE_PRODUCT_URL = '/api/product';

    /**
        Test that save a product.
     */
    public function test_save_a_product()
    {
        $data  = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'photo' => $this->faker->imageUrl(100, 100),
        ];
        $response = $this->post(self::SAVE_PRODUCT_URL, $data);
        $response->assertStatus(201);


        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Product saved successfully.',
        ]);
    }

    /**
        Test that save a product with required data.
     */
    public function test_save_a_product_with_invalid_data()
    {
        $data  = [];
        $response = $this->post(self::SAVE_PRODUCT_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The name field is required.', $response->json('message'));
        $this->assertContains('The price field is required.', $response->json('message'));
        $this->assertContains('The photo field is required.', $response->json('message'));
    }

    /**
        Test that save a product with max validation.
     */
    public function test_save_a_product_with_max_validation()
    {
        $data  = [
            'name' => Str::random(256),
            'photo' => Str::random(256),
        ];
        $response = $this->post(self::SAVE_PRODUCT_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The name must not be greater than 255 characters.', $response->json('message'));
        $this->assertContains('The photo must not be greater than 255 characters.', $response->json('message'));
    }

    /**
        Test that save a product with min validation.
     */
    public function test_save_a_product_with_price_min_then_0()
    {
        $data  = [
            'name' => $this->faker->name,
            'price' => -1,
            'photo' => $this->faker->imageUrl(100, 100),
        ];
        $response = $this->post(self::SAVE_PRODUCT_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The price must be at least 0.', $response->json('message'));
    }

    /**
        Test that update a product.
     */
    public function test_update_a_product()
    {
        $this->product = product::factory()->create();
        $data  = [
            'id' => $this->product->id,
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'photo' => $this->faker->imageUrl(100, 100),
        ];
        $response = $this->post(self::SAVE_PRODUCT_URL, $data);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Product saved successfully.',
        ]);
    }
}
