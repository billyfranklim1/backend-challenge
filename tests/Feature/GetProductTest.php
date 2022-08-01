<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetProductTest extends TestCase
{
    use DatabaseTransactions;

    private Product $product;
    const GET_PRODUCT_URL = '/api/product';

    /**
        Test that get a list of products.
     */
    public function test_get_a_list_of_products()
    {
        $response = $this->get(self::GET_PRODUCT_URL);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'photo',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ],
            ],
        ]);
    }

    /**
        Test that get a single product.
     */
    public function test_get_a_single_product()
    {
        $this->product = Product::factory()->create();
        $response = $this->get(self::GET_PRODUCT_URL . '/' . $this->product->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'price',
            'photo',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }

    /**
        Test that get a single product  with invalid id.
     */
    public function test_get_a_single_product_with_invalid_id()
    {
        $response = $this->get(self::GET_PRODUCT_URL . '/-1');
        $response->assertStatus(404);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Product not found',
        ]);

    }
}
