<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'name' => 'required|max:100',
            'service_amount' => 'required|numeric',
            'hours' => 'required|numeric',
            'minutes' => 'required|numeric',
            'repeat' => 'required|in:Not,Daily,Weekly,Monthly,Yearly',
            'repeat_every' => 'nullable|numeric',
            'ends' => 'nullable|in:Never,After',
            'ends_after_jobs' => 'nullable|numeric',
            'job_status' => 'required|in:Unconfirmed,Confirmed',
            'color_code' => 'required',
            'is_active' => 'required|in:0,1'
        ];
        return $rules;
    }
}
