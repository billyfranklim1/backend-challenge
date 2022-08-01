<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProductRequest;
use App\Http\Requests\DeleteProductRequest;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ProductController extends Controller
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
                $product = ProductRepository::find($id);
                if ($product) {
                    return response()->json($product);
                }
                return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '=>' . $th->getMessage());
            return response()->json(
                [
                    'message' => 'Get product failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $products = ProductRepository::getAll();
        return response()->json($products);
    }

    /**
     * save a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function save(SaveProductRequest $request)
    {
        DB::beginTransaction();
        try {

            ProductRepository::save($request->all());

            DB::commit();
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '=>' . $th->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Product save failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }


        return response()->json(
            [
                'message' => 'Product saved successfully.',
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteProductRequest $request)
    {
        DB::beginTransaction();
        try {

            $delete = ProductRepository::delete($request->id);

            if (!$delete) {
                return response()->json(
                    [
                        'message' => 'Product not found.',
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
                    'message' => 'Product delete failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(
            [
                'message' => 'Product deleted successfully.',
            ],
            Response::HTTP_OK
        );
    }
}
