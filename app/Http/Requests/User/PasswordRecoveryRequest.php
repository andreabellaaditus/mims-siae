<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PasswordRecoveryRequest extends FormRequest
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
            'email' => 'required|email|exists:users'
            // 'g-recaptcha-response' => 'recaptcha'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'required',
            'email.email' => 'invalid_format',
            'email.exists' => 'not_found',
            // 'g-recaptcha-response.recaptcha' => 'recaptcha'
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
