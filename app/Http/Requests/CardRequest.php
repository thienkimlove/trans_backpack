<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
        $rules = [
            'bank_id' => 'required',
            'customer_id' => 'required',
            'revert_date' => 'required|min:1|max:31',
            'trans_fee_percent' => 'required|min:1|max:99',
            'code' => 'required|min:3|max:30|unique:cards,code,'.$this->get('id')

        ];


        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
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
            'code.unique' => 'Mã thẻ phải không trùng lặp với mã thẻ khác đã có trong hệ thống',
            'code.min' => 'Mã thẻ phải có độ dài lớn hơn 2',
            'code.max' => 'Mã thẻ phải có độ dài nhỏ hơn 30',

            'code.required' => 'Bạn chưa nhập mã thẻ',
            'bank_id.required' => 'Bạn chưa chọn ngân hàng cho thẻ',
            'customer_id.required' => 'Bạn chưa chọn chủ thẻ',

            'revert_date.min' => 'Ngày đáo thẻ phải lớn hơn 0',
            'revert_date.max' => 'Ngày đáo thẻ phải nhỏ hơn 32',
            'revert_date.required' => 'Bạn chưa chọn ngày đáo thẻ',

            'trans_fee_percent.min' => 'Phí giao dịch (%) phải lớn hơn 0',
            'trans_fee_percent.max' => 'Phí giao dịch (%) phải nhỏ hơn 100',
            'trans_fee_percent.required' => 'Bạn chưa nhập phí giao dịch (%)',
        ];
    }
}
