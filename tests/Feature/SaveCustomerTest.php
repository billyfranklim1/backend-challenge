<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SaveCustomerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    private Customer $customer;
    const SAVE_CUSTOMER_URL = '/api/customer';

    /**
        Test that save a customer.
    */
    public function test_save_a_customer()
    {
        $data  = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'birthdate' => $this->faker->date('Y-m-d'),
            'address' => $this->faker->address,
            'complement' => $this->faker->address,
            'neighborhood' => $this->faker->address,
            'zipcode' => $this->faker->postcode,
        ];
        $response = $this->post(self::SAVE_CUSTOMER_URL, $data);
        $response->assertStatus(201);


        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Customer saved successfully.',
        ]);

    }

    /**
        Test that save a customer with required data.
    */
    public function test_save_a_customer_with_invalid_data()
    {
        $data  = [];
        $response = $this->post(self::SAVE_CUSTOMER_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The name field is required.', $response->json('message'));
        $this->assertContains('The email field is required.', $response->json('message'));
        $this->assertContains('The phone field is required.', $response->json('message'));
        $this->assertContains('The birthdate field is required.', $response->json('message'));
        $this->assertContains('The address field is required.', $response->json('message'));
        $this->assertContains('The neighborhood field is required.', $response->json('message'));
        $this->assertContains('The zipcode field is required.', $response->json('message'));

    }

    /**
        Test that save a customer with max validation.
    */
    public function test_save_a_customer_with_max_validation()
    {
        $data  = [
            'name' => Str::random(256),
            'phone' => Str::random(256),
            'address' => Str::random(256),
            'complement' => Str::random(256),
            'neighborhood' =>  Str::random(256),
            'zipcode' =>  Str::random(256),
        ];
        $response = $this->post(self::SAVE_CUSTOMER_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The name must not be greater than 255 characters.', $response->json('message'));
        $this->assertContains('The phone must not be greater than 255 characters.', $response->json('message'));
        $this->assertContains('The address must not be greater than 255 characters.', $response->json('message'));
        $this->assertContains('The complement must not be greater than 255 characters.', $response->json('message'));
        $this->assertContains('The neighborhood must not be greater than 255 characters.', $response->json('message'));
        $this->assertContains('The zipcode must not be greater than 255 characters.', $response->json('message'));

    }

    /**
        Test that save a customer with email validation.
    */
    public function test_save_a_customer_with_email_validation()
    {

        $data  = [
            'email' => $this->faker->word,
        ];

        $response = $this->post(self::SAVE_CUSTOMER_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The email must be a valid email address.', $response->json('message'));

    }


    /**
        Test that save a customer with email unique validation.
    */
    public function test_save_a_customer_with_email_unique_validation()
    {
        $this->customer = Customer::factory()->create();
        $data  = [
            'email' => $this->customer->email,
        ];

        $response = $this->post(self::SAVE_CUSTOMER_URL, $data);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $this->assertContains('The email has already been taken.', $response->json('message'));

    }

    /**
        Test that update a customer.
    */
    public function test_update_a_customer()
    {
        $this->customer = Customer::factory()->create();
        $data  = [
            'id' => $this->customer->id,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'birthdate' => $this->faker->date('Y-m-d'),
            'address' => $this->faker->address,
            'complement' => $this->faker->address,
            'neighborhood' => $this->faker->address,
            'zipcode' => $this->faker->postcode,
        ];
        $response = $this->post(self::SAVE_CUSTOMER_URL, $data);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJsonFragment([
            'message' => 'Customer saved successfully.',
        ]);

    }

}
