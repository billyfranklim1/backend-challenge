<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetCustomerTest extends TestCase
{
    use DatabaseTransactions;

    private Customer $customer;
    const GET_CUSTOMER_URL = '/api/customer';

    /**
        Test that get a list of customers.
    */
    public function test_get_a_list_of_customers()
    {
        $response = $this->get(self::GET_CUSTOMER_URL);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
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
            ],
        ]);
    }

    /**
        Test that get a single customer.
    */
    public function test_get_a_single_customer()
    {
        $this->customer = Customer::factory()->create();
        $response = $this->get(self::GET_CUSTOMER_URL . '/' . $this->customer->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
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
        ]);
    }

    /**
        Test that get a single customer with invalid id.
    */
    public function test_get_a_single_customer_with_invalid_id()
    {
        $response = $this->get(self::GET_CUSTOMER_URL . '/-1' );
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertJsonFragment([
            'message' => 'Customer not found',
        ]);
    }


}
