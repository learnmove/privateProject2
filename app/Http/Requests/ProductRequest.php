<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'=>'required',
            'price'=>'required|numeric',
            'quantity'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '缺少商品名稱',
            'price.required'=>'缺少價格',
            'price.numeric'=>'價格必需是數字',
            'quantity.required'=>'缺少數量',
            'quantity.numeric'=>'數量必需是數字',
         // 'newpassword.required' => Lang::get('userpasschange.newpasswordrequired'),
         // 'newpassword.min' => Lang::get('userpasschange.newpasswordmin6'),
         // 'newpassword.max' => Lang::get('userpasschange.newpasswordmax255'),
        ];
    }
}
