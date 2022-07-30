<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository extends Repository
{
    /**
     * Finds a product by id.
     *
     */
    public static function find(int $id)
    {
        return Product::find($id);
    }


    /**
     * Get all products.
     *
     */
    public static function getAll()
    {
        return Product::all();
    }


    /**
     * Creates a new instance, fill the fields, save in the database.
     *
     * @param array $params
     */
    public static function save(array $params)
    {
        $product = Product::updateOrCreate(
            ['id' => $params['id'] ?? null],
            $params
        );
        return $product->id;
    }

    /**
     * Delete a customer.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
