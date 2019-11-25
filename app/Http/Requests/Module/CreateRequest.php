<?php

namespace App\Http\Requests\Module;

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
            'name' => 'required|max:100',
            'description' => 'required|min:15',
            'type' => 'required',
            'priority' => 'required|numeric',
            'content' => 'required|json',
            'chapter_id' => 'required|uuid',
            'content_module_id' => 'required|numeric',
            'content_module_type' => 'required|string'
        ];
    }
}
