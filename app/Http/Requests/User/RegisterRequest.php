<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'title' => 'required|max:15|min:2',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'phone' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:10|confirmed',
            'date_of_birth' => 'required|date',
            'address' => 'required|min:5',
            'city' => 'required|min:5',
            'region' => 'required|min:5',
            'country' => 'required|min:5',
            'postal_code' => 'required|min:2',
            //'role_id' => 'required|exists:roles,id'
        ];
    }
}
