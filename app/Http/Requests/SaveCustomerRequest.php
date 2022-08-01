<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaveCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'exists:customers,id',
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:customers,email,'.$this->id.',id,deleted_at,NULL',
            'phone' => 'required|string|max:255',
            'birthdate' => 'required|date|date_format:Y-m-d',
            'address' => 'required|string|max:255',
            'complement' => 'string|max:255',
            'neighborhood' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
        ];
    }

    /**
     * In case validation fails, return message.
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $error_messages = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => $error_messages,
                ],
                Response::HTTP_BAD_REQUEST
            )
        );
    }
}
