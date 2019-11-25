<?php

namespace App\Http\Requests\Tag;

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
            'last_modified' => 'required|uuid',
            'name' => [
                'max:100',
                Rule::unique('tags', 'name')->where(function ($query) {
                    return $query->where('chapter_id', $this->chapter_id);
                }),
            ],
            'slug' => [
                'max:120',
                Rule::unique('tags', 'slug')->where(function ($query) {
                    return $query->where('chapter_id', $this->chapter_id);
                }),
            ],
            'isGlobal'=>'boolean',
            'hashtags'=>'json',
        ];
    }
}
