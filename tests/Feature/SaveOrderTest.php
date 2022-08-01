<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;

use Illuminate\Support\Str;

class SaveOrderTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    private Order $order;
    const SAVE_ORDER_URL = '/api/order';

    /**
        Test that save a order.
    */
    public function test_save_a_order()
    {

        $customer = Customer::factory()->create();
        $products = Product::factory()->count(3)->create();

        $data  = [
            'customer_id' => $customer->id,
            'products' => [
                [
                    'product_id' => $products[0]->id,
                    'quantity' => 13,
                ],
                [
                    'product_id' => $products[1]->id,
                    'quantity' => 16,
                ],
                [
                    'product_id' => $products[2]->id,
                    'quantity' => 19,
                ],
            ],
        ];

        $response = $this->post(self::SAVE_ORDER_URL, $data);
        $response->assertStatus(201);


        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Order saved successfully.',
        ]);

    }

    /**
        Test that save a order with required data.
    */
    public function test_save_a_order_with_invalid_data()
    {
        $data  = [];
        $response = $this->post(self::SAVE_ORDER_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The customer id field is required.', $response->json('message'));
        $this->assertContains('The products field is required.', $response->json('message'));

    }

    /**
        Test that save a order with quantity validation.
    */
    public function test_save_a_order_with_max_validation()
    {

        $customer = Customer::factory()->create();
        $products = Product::factory()->count(3)->create();

        $data  = [
            'customer_id' => $customer->id,
            'products' => [
                [
                    'product_id' => $products[0]->id,
                    'quantity' => -1,
                ],
                [
                    'product_id' => $products[1]->id,
                    'quantity' => -1,
                ],
                [
                    'product_id' => $products[2]->id,
                    'quantity' => -1,
                ],
            ],
        ];

        $response = $this->post(self::SAVE_ORDER_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The products.0.quantity must be at least 1.', $response->json('message'));
        $this->assertContains('The products.1.quantity must be at least 1.', $response->json('message'));
        $this->assertContains('The products.2.quantity must be at least 1.', $response->json('message'));

    }

    /**
        Test that update a order.
    */
    public function test_update_a_order()
    {
        $this->order = order::factory()->create();
        $products = Product::factory()->count(3)->create();

        $data  = [
            'id' => $this->order->id,
            'customer_id' => $this->order->customer_id,
            'products' => [
                [
                    'product_id' => $products[0]->id,
                    'quantity' => 13,
                ],
                [
                    'product_id' => $products[1]->id,
                    'quantity' => 16,
                ],
                [
                    'product_id' => $products[2]->id,
                    'quantity' => 19,
                ],
            ],
        ];
        $response = $this->post(self::SAVE_ORDER_URL, $data);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Order saved successfully.',
        ]);

    }

}
