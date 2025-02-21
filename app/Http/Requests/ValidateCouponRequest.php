<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'coupon_code' => 'required|string|max:50',
            'total_purchase' => 'required|numeric|min:0'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'valid' => false,
            'message' => $validator->errors()->first()
        ], 200));
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'coupon_code.required' => 'Coupon code is required.',
            'total_purchase.required' => 'Total purchase amount is required.',
            'total_purchase.numeric' => 'Total purchase must be a number.',
            'total_purchase.min' => 'Total purchase must be a positive number.'
        ];
    }
}
