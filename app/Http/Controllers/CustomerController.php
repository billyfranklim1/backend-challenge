<?php

namespace App\Http\Controllers;

use App\Repository\CustomerRepository;
use App\Http\Requests\SaveCustomerRequest;
use App\Http\Requests\DeleteCustomerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource or a single customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id = null)
    {
        try {

            if ($id) {
                $customer = CustomerRepository::find($id);
                if ($customer) {
                    return response()->json($customer);
                }
                return response()->json(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '=>' . $th->getMessage());
            return response()->json(
                [
                    'message' => 'Get customer failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $customers = CustomerRepository::getAll();
        return response()->json($customers);
    }

    /**
     * save a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function save(SaveCustomerRequest $request)
    {
        DB::beginTransaction();
        try {

            CustomerRepository::save($request->all());

            DB::commit();
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . '=>' . $th->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Customer save failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }


        return response()->json(
            [
                'message' => 'Customer saved successfully.',
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteCustomerRequest $request)
    {
        DB::beginTransaction();
        try {

            $delete = CustomerRepository::delete($request->id);

            if (!$delete) {
                return response()->json(
                    [
                        'message' => 'Customer not found.',
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
                    'message' => 'Customer delete failed.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(
            [
                'message' => 'Customer deleted successfully.',
            ],
            Response::HTTP_OK
        );
    }
}
