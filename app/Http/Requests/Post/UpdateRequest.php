<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => 'max:100',
            'slug' => [
                'max:120',
                Rule::unique('posts', 'slug')->where(function ($query) {
                    return $query->where('chapter_id', $this->chapter_id);
                }),
            ],
            'isGlobal' => 'boolean',
            'published' => 'date',
            'last_modified' => 'required|exists:chapters,id|uuid'
        ];
    }
}
