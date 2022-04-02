<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
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
    public function rules($user)
    {
        return [
                'name'  => ['required', 'string', 'max: 20'],
                'email'  => ['required', 'email', 'max: 255', Rule::unique('users')->ignore($user->id)],
                'password'      =>['required|confirmed|max:255|min:8'],
                'password_confirmation'=> ['required|same:password'],
        ];
    }
}
