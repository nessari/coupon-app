<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutFormRequest extends FormRequest
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
        $email = Auth::user() ? ['required', 'min:8', 'max:100', 'email'] : ['required', 'min:8', 'max:100', 'email', 'unique:users'];
        return [
            'email' => $email,
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'password' => ['sometimes', 'required', 'min:8', 'max:20'],
            'address' => ['required', 'string', 'min:3', 'max:50'],
            'city' => ['required', 'string', 'min:2', 'max:20'],
            'zip_code' => ['required', 'string', 'min:4', 'max:5'],
        ];
    }
}
