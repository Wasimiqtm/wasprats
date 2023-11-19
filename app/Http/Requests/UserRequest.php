<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
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
        $rules = [
            'role_id' => 'required|exists:roles,id',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'username' => 'required|max:50|unique:users,username,' . $this->id,
            'license_no' => 'nullable|max:50',
            'email' => 'required|email|max:100|unique:users,email,' . $this->id
        ];

        if ($this->id) {
            $rules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
        } else {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        return $rules;
    }
}
