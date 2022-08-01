<?php

namespace App\Repository;

use App\Models\Customer;

class CustomerRepository extends Repository
{

    /**
     * Finds a customer by id.
     *
     */
    public static function find(int $id)
    {
        return Customer::find($id);
    }


    /**
     * Get all customers.
     *
     */
    public static function getAll()
    {
        return Customer::paginate(10);
    }

    /**
     * Creates a new instance, fill the fields, save in the database.
     *
     * @param array $params
     */
    public static function save(array $params)
    {
        $customer = Customer::updateOrCreate(
            ['id' => $params['id'] ?? null],
            $params
        );
        return $customer->id;
    }

    /**
     * Delete a customer.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
            return true;
        }
        return false;
    }
}
