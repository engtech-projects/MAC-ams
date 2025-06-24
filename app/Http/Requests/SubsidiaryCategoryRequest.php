<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubsidiaryCategoryRequest extends FormRequest
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
            'sub_cat_code' => 'required|string',
            'sub_cat_name' => 'required|string',
            'sub_cat_type' => 'nullable|string',
            'description' => 'required|',
            'account_id_credit' => 'required|numeric',
            'account_id_debit' => 'required|numeric',
        ];
    }
}
