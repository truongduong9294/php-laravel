<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            // 'user_name'   => 'required|min:4|max:20|unique:users,user_name,'.request('user')['id'],
            'user_name'   => 'required|min:4|max:20',
            'name'       => 'required|min:4|max:20',
            'email'      => 'required|email|min:4|max:40',
            'avatar'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id'    => 'required|integer',
            'password'   => 'required|min:4|max:20'
        ];
    }
}
