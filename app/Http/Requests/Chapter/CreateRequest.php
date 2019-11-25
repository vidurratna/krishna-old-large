<?php

namespace App\Http\Requests\Chapter;

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
            'name' => 'required|min:5',
            'country' => 'required|min:5',
            'region' => 'required|min:5',
            'founded' => 'required|date|min:5',
            'active' => 'boolean',
            'subdomain' => 'required|min:5|unique:chapters',
        ];
    }
}
