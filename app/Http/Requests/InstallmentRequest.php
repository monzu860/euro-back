<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallmentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'bail|required|integer',
            'installments.*.expire_date' => 'bail|required|date',
            'installments.*.amount' => 'bail|required|numeric',
            'installments' => 'bail|required|array|min:2',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {

        throw new \Illuminate\Validation\ValidationException($validator,response()->json($validator->errors()->first(), 422));
    }
}
