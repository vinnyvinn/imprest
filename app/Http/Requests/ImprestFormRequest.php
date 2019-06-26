<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImprestFormRequest extends FormRequest
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
            'imprest_number' => 'required',
            //'applicant_id' => 'required'
            // 'account_number' => 'required',
            // 'advance_amount' => 'required'
        ];
    }
}
