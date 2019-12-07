<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => 'required|min:5|unique:addresses',
            'address1' => 'required|min:5',
            'address2' => 'min:5',
            'address2' => 'min:5',
            'city' => 'required|min:5',
            'region' => 'required|min:5',
            'country' => 'required|min:5',
            'postalcode' => 'required|min:2',
            'created_by' => 'required|uuid',
            'isGlobal' => 'boolean'
        ];
    }
}
