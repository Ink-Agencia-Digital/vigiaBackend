<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            "name" => "required|string",
            "lastname" => "required|string",
            "phone" => "required|string|unique:users,phone",
            "email" => "required|email|string|unique:users,email",
            "password" => "required|min:8|confirmed",
            "role" => "exists:roles,name",
        ];
    }
}
