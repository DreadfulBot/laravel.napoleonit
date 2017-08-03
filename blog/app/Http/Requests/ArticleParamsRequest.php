<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleParamsRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'user_id' => 'required|integer|exists:users,id',
            'image' => 'required|mimes:png,gif,jpeg|max:20000',
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|max:255|min:3',
            'content' => 'required|string|max:1000|min:3',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'категория - не указано',
            'category_id.integer' => 'категория - неверный формат',
            'category_id.exists' => 'категория - не найдено в базе',

            'user_id.required' => 'пользователь - не указано',
            'user_id.integer' => 'пользователь - неверный формат',
            'user_id.exists' => 'пользователь - не найдено в базе',

            'image.mimes' => 'изображение - неверный формат',
            'image.max' => 'изображение - слишком большой размер файла',

            'title.required' => 'заголовок - не указано',
            'title.string' => 'заголовок - неверный формат',
            'title.max' => 'заголовок - максимальная длина = 255',
            'title.min' => 'заголовок - минимальная длина = 3',

            'description.required' => 'заголовок - не указано',
            'description.string' => 'заголовок - неверный формат',
            'description.max' => 'заголовок - максимальная длина = 255',
            'description.min' => 'заголовок - минимальная длина = 3',

            'content.required' => 'контент - не указано',
            'content.string' => 'контент - неверный формат',
            'content.max' => 'контент - максимальная длина = 1000',
            'content.min' => 'контент - минимальная длина = 3',
        ];
    }
}
