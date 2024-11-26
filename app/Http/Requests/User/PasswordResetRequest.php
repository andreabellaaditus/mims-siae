<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PasswordResetRequest extends FormRequest
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
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required|exists:password_resets'
            // 'g-recaptcha-response' => 'recaptcha'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'required',
            'password_confirmation.required' => 'required',
            'password.confirmed' => 'not_same_passwords',
            'token.required' => 'required',
            'token.exists' => 'not_found'
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
