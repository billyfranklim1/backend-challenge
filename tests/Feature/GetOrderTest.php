<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetOrderTest extends TestCase
{
    use DatabaseTransactions;

    private Order $order;
    const GET_ORDER_URL = '/api/order';

    /**
        Test that get a list of orders.
     */
    public function test_get_a_list_of_orders()
    {
        $response = $this->get(self::GET_ORDER_URL);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'customer_id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'products' => [
                        '*' => [
                            'id',
                            'name',
                            'price',
                            'photo',
                            'created_at',
                            'updated_at',
                            'deleted_at',
                            'pivot' => [
                                'order_id',
                                'product_id',
                                'quantity',
                            ],
                        ],
                    ],
                    'customer' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'birthdate',
                        'address',
                        'complement',
                        'neighborhood',
                        'zipcode',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                    ]
                ]
            ]
        ]);
    }

    /**
        Test that get a single order.
     */
    public function test_get_a_single_order()
    {
        $this->order = Order::factory()->create();
        $products = Product::factory(5)->create();

        foreach ($products as $product) {
            $this->order->products()->attach($product->id, [
                'quantity' => rand(1, 10),
            ]);
        }


        $response = $this->get(self::GET_ORDER_URL . '/' . $this->order->id);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'customer_id',
            'created_at',
            'updated_at',
            'deleted_at',
            'products' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'photo',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'pivot' => [
                        'order_id',
                        'product_id',
                        'quantity',
                    ],
                ],
            ],
            'customer' => [
                'id',
                'name',
                'email',
                'phone',
                'birthdate',
                'address',
                'complement',
                'neighborhood',
                'zipcode',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
        ]);
    }

    /**
        Test that get a single order with invalid id.
     */
    public function test_get_a_single_order_with_invalid_id()
    {
        $response = $this->get(self::GET_ORDER_URL . '/-1' );
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Order not found',
        ]);
    }
}
