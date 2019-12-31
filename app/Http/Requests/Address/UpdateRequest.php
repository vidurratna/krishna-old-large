<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'min:5|unique:addresses',
            'address1' => 'min:5',
            'address2' => 'min:5',
            'address2' => 'min:5',
            'city' => 'min:5',
            'region' => 'min:5',
            'country' => 'min:5',
            'postalcode' => 'min:2',
            'last_modified' => 'required|uuid',
            'isGlobal' => 'boolean'
        ];
    }
}
