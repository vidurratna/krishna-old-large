<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => 'max:100',
            'slug' => 'max:120',
            'created_by' => 'exists:users,id|uuid',
            'chapter_id' => 'exists:chapters,id|numeric',
            'isGlobal' => 'boolean',
            'published' => 'date'
        ];
    }
}
