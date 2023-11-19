<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'name' => 'required|max:100|unique:items,name,' . $this->id,
            'description' => 'nullable',
            'cost' => 'required|numeric',
            'tax_1' => 'nullable',
            'tax_2' => 'nullable',
        ];
    }
}
