<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CookRequest extends FormRequest
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
            'title'        =>['required', 'string', 'max:255'],
            'body' =>        ['required', 'string', 'max:2000'],
            'category'    => ['required', 'integer'],
            'image'=>        ['image|max:1024'],
        ];
    }


    public function attributes()
     {
         return [
             'title'        => 'レシピ名',
             'body'        => 'レシピの作り方',
             'category'    => 'カテゴリ',
             'image'    => '画像',
         ];
     }
}
