<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MachineRequest extends FormRequest
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
            'bank_id' => 'required',
            'fee_percent_per_trans' => 'required|min:1|max:99',
            'code' => 'required|min:3|max:30|unique:machines,code,'.$this->get('id')

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
            'bank_id.required' => 'Bạn chưa chọn ngân hàng cho máy POS',

            'fee_percent_per_trans.required' => 'Bạn chưa nhập phí giao dịch (%)',
            'fee_percent_per_trans.min' => 'Phí giao dịch (%) phải lớn hơn 0',
            'fee_percent_per_trans.max' => 'Phí giao dịch (%) phải nhở hơn 100',

            'code.unique' => 'Mã máy POS phải không trùng lặp với mã máy khác đã có trong hệ thống',
            'code.min' => 'Mã máy POS phải có độ dài lớn hơn 2',
            'code.max' => 'Mã máy POS phải có độ dài nhỏ hơn 30',
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
