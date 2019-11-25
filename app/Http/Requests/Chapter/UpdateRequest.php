<?php

namespace App\Http\Requests\Chapter;

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
            'name' => 'min:5',
            'country' => 'min:5',
            'region' => 'min:5',
            'founded' => 'date|min:5',
            'active' => 'boolean',
            'subdomain' => 'min:5|unique:chapters',
        ];
    }
}
