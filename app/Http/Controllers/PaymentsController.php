<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ScheduleJob;
use App\Models\Service;
use App\Models\ServicePayment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use PDF;
use DataTables;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $serviceId)
    {
        $job = ScheduleJob::with(['services','customer', 'schedule.user'])->whereId($serviceId)->first();

        $tab = 'all';
        if ($request->filled('tab') && in_array($request->tab, ['full', 'partial'])) {
            $tab = $request->tab;
        }
        $services = ServicePayment::with('service', 'customer', 'user')->where('schedule_job_id', $serviceId)->get();
        if ($request->ajax()) {
            $services = ServicePayment::with('service', 'customer', 'user')->where('service_id', $serviceId);
            switch ($tab) {
                case 'full':
                    $services->where('payment_mode', 'full');
                    break;
                case 'partial':
                    $services->where('payment_mode', 'partial');
                    break;
                default:
                    $services;
                    break;
            }
            return Datatables::of($services)
                /*->addColumn('payable', function ($payment) {
                    return $payment->service->service_amount - $payment->amount;
                })*/
                ->addColumn('action', function ($servicePaymentId) {
                   $action = '<td><div class="overlay-edit">';
                   $action .= '<a href="'.route('single.payment.invoice', $servicePaymentId).'" class="btn btn-icon btn-secondary"><i class="feather icon-user-check"></i></a>';
                   $action .= '</div></td>';
                   return $action;
               })
                ->editColumn('id', 'ID: {{$id}}')
                ->editColumn('created_at', function (ServicePayment $servicePayment) {
                    return \Carbon\Carbon::parse($servicePayment->created_at )->isoFormat('DD-MM-YYYY');
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }
        $service = Service::uuid($serviceId)->first();
        $customers = Customer::get();
        $allUsers = User::get();
        $users = [];
        foreach($allUsers as $user){
            if( $user->getRoleNames()->first() ==='Technician') {
                $users[] = $user;
            }
        }

        return view('services.payments', compact('service', 'customers', 'users', 'job'), get_defined_vars());
    }

    /**
     * Add payment against a service
     *
     */
    public function addServicePayment(Request $request)
    {
        $service =  Service::where('id', $request->service_id)->first();
        $data = [
            'schedule_job_id' => $request->schedule_job_id,
            'service_id' => $service->id,
            'customer_id' => $request->customer_id,
            'user_id' => $request->user_id,
            'payment_mode' => $request->payment_mode,
            'amount' => $request->amount,
            'description' => $request->description
        ];
        ServicePayment::create($data);
        Session::flash('success', __('Payment successfully added!'));
        return ['status' => true];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     public function amountInvoice($serviceId)
    {
        $currentTime = Carbon::now();
        $fileName =  $currentTime->toDateTimeString();
        $items = ServicePayment::with('service', 'customer', 'user')->where('service_id', $serviceId)->get();
        view()->share('items',$items);
        $pdf = PDF::loadView('services.amount_invoice');
        return $pdf->download($fileName.'invoice.pdf');
        
    }

    public function singlePaymentInvoice($servicePaymentId)
    {
        
        $currentTime = Carbon::now();
        $fileName =  $currentTime->toDateTimeString();
        $servicePayment = ServicePayment::where('id', $servicePaymentId)->with('service', 'customer', 'user')->first();
        view()->share('servicePayment',$servicePayment);
        $pdf = PDF::loadView('services.single_payment_invoice');
        return $pdf->download($fileName.' payment invoice.pdf');
        
    }
}
