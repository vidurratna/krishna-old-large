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
            'title' => 'required',
            'slug' => [
                'required',
                Rule::unique('posts', 'slug')->where(function ($query) {
                    return $query->where('chapter_id', $this->chapter_id);
                }),
            ],
            'created_by' => 'required|exists:users,id',
            'chapter_id' => 'required|exists:chapters,id',
            'isGlobal' => 'boolean'
        ];
    }
}
