<?php

namespace App\Http\Requests;
use App\Models\Service;
use App\Models\ServicePayment;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ServicePaymentRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $applyTax =  Tax::where('is_active',1)->value('rate');
        $usedServicePayment = ServicePayment::where('schedule_job_id', $request->schedule_job_id)->sum('amount');
        $service =  Service::where('id', $request->service_id)->pluck('service_amount')->first();
        $totalTax = ($service * $applyTax)/100;
        $totalServiceAmount = (int) $totalTax + (int) $service;
        $remainingAmount = (int) $totalServiceAmount - (int) $usedServicePayment;
        return [
            'amount' => 'required|integer|min:1|max:'.$remainingAmount,
        ];
    }
}
