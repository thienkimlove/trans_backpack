<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required|min:3|max:30|unique:customers,code,'.$this->get('id')

        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên khách hàng',
            'code.unique' => 'Mã khách hàng phải không trùng lặp với mã khách hàng khác đã có trong hệ thống',
            'code.min' => 'Mã khách hàng phải có độ dài lớn hơn 2',
            'code.max' => 'Mã khách hàng phải có độ dài nhỏ hơn 30',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
