<?php

namespace App\Repository;

use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderDetails;

class OrderRepository extends Repository
{
    /**
     * Finds a product by id.
     *
     */
    public static function find(int $id)
    {
        return Order::with(['products', 'customer'])->find($id);
    }


    /**
     * Get all products.
     *
     */
    public static function getAll()
    {
        return Order::with(['products', 'customer'])->paginate(10);
    }


    /**
     * Creates a new instance, fill the fields, save in the database.
     *
     * @param array $params
     */
    public static function save(array $params)
    {
        $order = Order::updateOrCreate(
            ['id' => $params['id'] ?? null],
            $params
        );

        if (isset($params['products'])) {
            $order->products()->sync($params['products']);
        }

        Mail::to($order->customer->email)->send(new OrderDetails($order->id));

        return $order->id;
    }

    /**
     * Delete a customer.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->products()->sync([]);
            $order->delete();
            return true;
        }
        return false;
    }
}
