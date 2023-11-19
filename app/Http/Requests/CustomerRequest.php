<?php

namespace App\Http\Requests;

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
            'first_name' => 'required|max:50',
            'last_name' => 'nullable|max:50',
            'account_no' => 'required|max:50|unique:customers,account_no,' . $this->id,
            'email' => 'required|max:50|unique:customers,email,' . $this->id,
            'company_name' => 'nullable|max:50',
            'phone' => 'nullable|max:30',
            'is_active' => 'required|in:0,1'
        ];
    }
}
