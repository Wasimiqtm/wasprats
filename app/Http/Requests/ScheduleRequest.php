<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'name' => 'required|max:100|unique:schedules,name,' . $this->id,
            'nickname' => 'required|max:50|unique:schedules,nickname,' . $this->id,
            'user_id' => 'required',
            'group_ids' => 'required',
            'start' => 'nullable',
            'end' => 'nullable',
        ];
    }
}
