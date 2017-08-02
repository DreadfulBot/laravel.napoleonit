<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryParamsRequest extends FormRequest
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
            'category' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
          'category.required' => 'категория - не указано',
          'category.string' => 'категория - неверный формат',
          'category.max' => 'категория - максимальная длина 255',
        ];
    }
}
