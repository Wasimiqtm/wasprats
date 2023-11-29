<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\ScheduleJob;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Session;
use DataTables;
use Auth;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $customerId)
    {
        $tab = 'active';
        if ($request->filled('tab') && in_array($request->tab, ['completed', 'canceled'])) {
            $tab = $request->tab;
        }

        if ($request->ajax()) {
            $jobs = ScheduleJob::with('services')->where('customer_id', $customerId);

            switch ($tab) {
                case 'completed':
                    $jobs->where('status', 'completed');
                    break;
                case 'canceled':
                    $jobs->where('status', 'canceled');
                    break;
                default:
                    $jobs->where('status', 'active');
                    break;
            }

            $user = Auth::user();

            return Datatables::of($jobs)
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        $customer = Customer::uuid($customerId)->first();
        return view('customers.jobs', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        exit('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'service_id' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, $validator->errors()->first(), [], 403);
        }

        $requestData = $request->all();
        $from = explode('T', $request->from);
        $requestData['from_date'] = $from[0];
        if (isset($from[1])) {
            $fromTime = explode('+', $from[1]);
            $requestData['from_time'] = $fromTime[0];
        } else {
            $requestData['from_time'] = '00:00:00';
        }

        $to = explode('T', $request->to);
        $requestData['to_date'] = $to[0];
        if (isset($to[1])) {
            $toTime = explode('+', $to[1]);
            $requestData['to_time'] = $toTime[0];
        } else {
            $requestData['to_time'] = '23:59:59';
        }

        $job = Job::with('service', 'customer')->create($requestData);
        $event = getEventObject($job);

        return $this->sendResponse(true, 'Job successfully created', ['event' => $event]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\Company;
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\CompanyRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Company $company, CompanyRequest $request)
    {
        $company->update($request->validated());

        Session::flash('success', __('Company successfully updated!'));
        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Models\Company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if ($company) {
            $company->delete();
            return response()->json([
                'message' => __('Company deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Company not exist against this id')
        ], $this->errorStatus);
    }

    /**
     * Update Job
     *
     * @param Request $request
     * @return JSON
     */
    function updateJob(Request $request)
    {

        $from = explode('T', $request->from);
        $requestData['from_date'] = $from[0];
        if (isset($from[1])) {
            $fromTime = explode('+', $from[1]);
            $requestData['from_time'] = $fromTime[0];
        } else {
            $requestData['from_time'] = '00:00:00';
        }
        if(isset($request->to)) {
            $to = explode('T', $request->to);
            $requestData['to_date'] = $to[0];
            if (isset($to[1])) {
                $toTime = explode('+', $to[1]);
                $requestData['to_time'] = $toTime[0];
            } else {
                $requestData['to_time'] = '23:59:59';
            }
        }

        $job = Job::find($request->id);
        dd($job);
        if ($job) {
            $job->update($requestData);
        }

        return $this->sendResponse(true, 'Job successfully updated');
    }

    public function assignJob()
    {

        $customer = Customer::where('uuid', \request()->customer_id)->first();
        $data = ScheduleJob::create([
            'location_id' => \request()->location,
            'customer_id' => $customer->id,
            'service_id' => \request()->customer_job_service,
            'date' => \request()->JobEvent['date'],
            'time' => \request()->JobEvent['time'],
            'hours' => \request()->JobEvent['hours'],
            'minutes' => \request()->JobEvent['minutes'],
            'recurance' => json_encode(request()->JobEvent['recurrence']),
            'schedule_id' => \request()->JobEvent['primary_schedule_id'],
            'confirmed' => \request()->JobEvent['always_confirmed'],
            'locked' => \request()->JobEvent['locked'],
            'customer_status' => \request()->CustomerJob['status'],
            'repeat_frequency' => \request()->repeat_frequency,
            'notes' => \request()->Note['note'],
        ]);
        $service = Service::find(\request()->customer_job_service);
        $invoice = Invoice::create([
            'customer_id' => $customer->id,
            'job_id' => $data->id,
            'total' => $service->invoice_total,
            'frequency' => \request()->repeat_frequency
        ]);

        return $this->sendResponse(true, 'Job successfully updated');
    }

    public function customerJobDetails()
    {
        $customer = Customer::where('uuid', \request()->customer_id)->first();
        $schedule = ScheduleJob::with(['customer', 'invoice', 'services', 'schedule.user'])->where('customer_id', $customer->id)->get();

        return DataTables::of($schedule)
            ->addColumn('service_name', function ($data) {
                return $data->services->name . '(loaction:- Home)';
            })->addColumn('invoice_frequency', function ($data) {
                return $data->invoice ? $data->invoice->frequency : 0;
            })
            ->addColumn('job_frequency', function ($data) {
                $jsonData = json_decode($data->recurance);

                return $jsonData->interval . '' . $jsonData->frequency;
            })->addColumn('assigned_to', function ($data) {
                if ($data->schedule->user) {
                    return $data->schedule->user->name;
                } else {
                    return $data->schedule->name;
                }
            })->addColumn('total', function ($data) {
                if ($data->invoice) {
                    return $data->invoice->total;
                } else {
                    return 0;
                }
            })->addColumn('action', function ($customer) {

                $action = '<td><div class="overlay-edit">';


                $action .= '<a href="javascript:void(0)" class="btn btn-icon btn-secondary editRecord" data-id="' . $customer->id . '" data-status="' . $customer->status . '" title="Jobs"><i class="feather icon-edit"></i></a>';


                $action .= '</div></td>';

                return $action;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function updateCustomerJobStatus()
    {
        $data = ['status' => \request()->job_status];
        if(\request()->job_status =='completed'){
            $data['completed_by'] = auth()->user()->id;
        }
        ScheduleJob::whereId(\request()->job_id)->update($data);
        return $this->sendResponse(true, 'Job successfully updated');
    }
}
