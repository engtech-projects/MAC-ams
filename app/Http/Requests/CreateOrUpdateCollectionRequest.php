<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\CollectionBreakdown;

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
            "transaction_date" => 'required|date|unique:collection_breakdown,transaction_date,NULL,id,branch_id,' . $this->branch_id,
            //"transaction_date" => 'required|date',
            "branch_id" => 'required|numeric',
            "total" => 'numeric',
            "account_officer_collections" => "required|array",
            "branch_collections" => "required|array",
            "other_payment" => "required",
            "other_payment" => "required",
        ];
    }
    public function messages()
    {
        return [
            'transactionDate.required' => 'The transaction date is required.',
            'transactionDate.date' => 'The transaction date must be a valid date.',
            'transactionDate.unique' => 'The transaction date has already been used for this branch.',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge(['flag' => CollectionBreakdown::COLLECTION_FLAG]);
        if (Auth::user()->can('manager')) {
            $this->merge(['branch_id' => $this->input('branch_id')]);
        } else {
            $this->merge(['branch_id' => session()->get('auth_user_branch')]);
        }
    }
}
