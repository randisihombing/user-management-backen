<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $this->route('id'),
            'avatar' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
