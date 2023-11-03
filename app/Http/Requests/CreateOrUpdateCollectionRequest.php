<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateCollectionRequest extends FormRequest
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
            "p_1000" => 'required|numeric',
            "p_500" => 'required|numeric',
            "p_200" => 'required|numeric',
            "p_100" => 'required|numeric',
            "p_50" => 'required|numeric',
            "p_20" => 'required|numeric',
            "p_10" => 'required|numeric',
            "p_5" => 'required|numeric',
            "p_1" => 'required|numeric',
            "c_25" => 'required|numeric',
            "transaction_date" => 'required|date',
            "branch_id" => 'required|numeric',
            "total" => 'required|numeric',
            "collection_ao" => "required",
        ];
    }
}
