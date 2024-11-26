<?php

namespace App\Http\Requests\CartProduct;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DestroyManyRequest extends FormRequest
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
            'ids' => 'required|array',
            'ids.*.id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'ids.required' => 'The ids field is required.',
            'ids.array' => 'The ids field must be an array.',
            'ids.*.id.required' => 'Each item must have an id.',
            'ids.*.id.integer' => 'Each id must be an integer.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'status' => $validator->errors()
            ])
        );
    }
}
