<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'email|required|unique:users',
            'cpf' => 'required|string|unique:users',
            'phone' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:6|max:255',
            'password_confirmation' => 'required|string|min:6|max:255',
        ];
    }
}
