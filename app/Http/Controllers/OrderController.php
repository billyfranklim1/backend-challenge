<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveOrderRequest;
use App\Http\Requests\DeleteOrderRequest;
use App\Repository\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource or a single product.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id = null)
    {
        try {

            if ($id) {
                $order = OrderRepository::find($id);
                if ($order) {
                    return response()->json($order);
                }
                return response()->json(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '=>' . $th->getMessage());
            return response()->json(
                [
                    'message' => 'Get order failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $orders = OrderRepository::getAll();
        return response()->json($orders);
    }

    /**
     * save a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function save(SaveOrderRequest $request)
    {
        DB::beginTransaction();
        try {

            OrderRepository::save($request->all());

            DB::commit();
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '=>' . $th->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Order save failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }


        return response()->json(
            [
                'message' => 'Order saved successfully.',
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteOrderRequest $request)
    {
        DB::beginTransaction();
        try {

            $delete = OrderRepository::delete($request->id);

            if (!$delete) {
                return response()->json(
                    [
                        'message' => 'Order not found.',
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            DB::commit();
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '=>' . $th->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Order delete failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(
            [
                'message' => 'Order deleted successfully.',
            ],
            Response::HTTP_OK
        );
    }
}
