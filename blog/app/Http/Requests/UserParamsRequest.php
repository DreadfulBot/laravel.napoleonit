<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserParamsRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'имя - не указано',
            'name.string' => 'имя - неверный формат',
            'name.255' => 'имя - максимальная длина 255',

            'email.required' => 'email - не указано',
            'email.string' => 'email - неверный формат',
            'email.email' => 'email - неверный формат',
            'email.max' => 'email - максимальная длина 255',
            'email.unique' => 'email - уже зарегистрирован',

            'password.required' => 'пароль - не указано',
            'password.string' => 'пароль - неверный формат',
            'password.min' => 'пароль - минимальная длина 6',
            'password.confirmed' => 'пароль - не совпадает с повтором',

            'role.required' => 'пароль - не совпадает с повтором',
            'role.integer' => 'пароль - неверный формат',
        ];
    }
}