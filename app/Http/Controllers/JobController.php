<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Tax;
use App\Models\User;
use App\Models\ScheduleJob;
use App\Models\Service;
use App\Models\CustomerLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Mail;
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
            $scheduleJob = ScheduleJob::where('id',$request->id)->first();
            if(isset($scheduleJob)) {
                $getData = $request->from;
                $formattedDate = Carbon::parse($getData)->format('Y-m-d');
                $formattedTime = Carbon::parse($getData)->format('H:i');
                $scheduleJob->date = $formattedDate;
                $scheduleJob->time = $formattedTime;
                $scheduleJob->save();
            }
        // $from = explode('T', $request->from);
        // $requestData['from_date'] = $from[0];
        // if (isset($from[1])) {
        //     $fromTime = explode('+', $from[1]);
        //     $requestData['from_time'] = $fromTime[0];
        // } else {
        //     $requestData['from_time'] = '00:00:00';
        // }
        // if(isset($request->to)) {
        //     $to = explode('T', $request->to);
        //     $requestData['to_date'] = $to[0];
        //     if (isset($to[1])) {
        //         $toTime = explode('+', $to[1]);
        //         $requestData['to_time'] = $toTime[0];
        //     } else {
        //         $requestData['to_time'] = '23:59:59';
        //     }
        // }

        // $job = Job::find($request->id);
        // if ($job) {
        //     $job->update($requestData);
        // }

        return $this->sendResponse(true, 'Job successfully updated');
    }

    public function assignJob()
    {
        $formattedDate = null;
        $formattedTime = null;
        if(isset(\request()->from)) {
            $getData = \request()->from;
            $formattedDate = Carbon::parse($getData)->format('Y-m-d');
            $formattedTime = Carbon::parse($getData)->format('H:i');
        }
        //dd(config('mail.mailers.smtp'));
        $customer = Customer::where('uuid', \request()->customer_id)->first();
        $data = ScheduleJob::create([
            'location_id' => isset(\request()->location) ? \request()->location : null,
            'customer_id' => $customer->id,
            'service_id' => \request()->customer_job_service,
            'date' => isset($formattedDate) ? $formattedDate : \request()->JobEvent['date'],
            'time' => isset($formattedTime) ? $formattedTime :\request()->JobEvent['time'],
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
        // Send email
        $customerLocation = null;
        if(isset(\request()->location)) {
            $customerLocation = CustomerLocation::where('id',\request()->location)->first();
        }
        $userMail = (isset($data->schedule) && isset($data->schedule->user)) ? $data->schedule->user->email : null;
        $customerMail = isset($customer) ? $customer->email : null;
        $usersEmail = [$userMail,$customerMail];
        $displayData = ['id' => $data->id,
            'created_at' => $data->created_at,
            'date' => $data->date,
            'time' => $data->time,
            'hours' => $data->hours,
            'minutes' => $data->minutes,
            'recurance' => $data->recurance,
            'confirmed' => ($data->confirmed == 1) ? 'Yes' : 'No',
            'repeat_frequency' => $data->repeat_frequency,
            'customer_status' => ($data->customer_status == 1) ? 'Yes' : 'No',
            'notes' => $data->notes,
            'customer' => $customer->first_name. ' ' .$customer->last_name,
            'service' => $service->name,
            'customer_location' => isset($customerLocation) ? $customerLocation->name : null,
            'total' => $service->invoice_total,
            'user' => (isset($data->schedule) && isset($data->schedule->user)) ? $data->schedule->user->name : null
        ];
        $pdf = PDF::loadView('customers.job_file', compact('displayData'));
        foreach ($usersEmail as $key => $emailData) {

            $detail["email"] = $emailData;
            $detail["title"] = "Job Confirmation";
            $detail["body"] = "An invoice is a document that charges a customer for goods or services you've provided. Also called a bill, an invoice shows all the information about a transaction. This includes: the quantity of any goods or services provided. the rate charged.";

        $message = '
            <!DOCTYPE html>
             <html lang="en-EN">
              <head>
                <meta charset="utf-8">
              </head>
              <body bgcolor="#11C9FF">
                <p>'. $detail["body"] .'</p>
            	<div align="left">
               		<h3>Kindly see the attachment.</h3>
               </div>
              </body>
            </html>';


        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Waspsrats <info@waspsrats.com>' . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

        // Create the email body
        $body = "--boundary\r\n";
        $body .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
        $body .= $message . "\r\n\r\n";

        $attachment_path = "Job Confirmation.pdf"; // Replace with the actual path to your PDF file
        $file_encoded = base64_encode($pdf->output());

        $body .= "--boundary\r\n";
        $body .= "Content-Type: application/pdf; name=\"" . basename($attachment_path) . "\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment\r\n\r\n";
        $body .= chunk_split($file_encoded) . "\r\n";
        $body .= "--boundary--";

        mail($detail["email"], $detail["title"], $body, $headers);

            // Mail::send('customers.send-job-email', $detail, function($message)use($detail, $pdf) {
            //     $message->to($detail["email"], $detail["email"])
            //             ->subject($detail["title"])
            //             ->attachData($pdf->output(), 'job-confirmation-invoice.pdf');
            // });
        }
          return $this->sendResponse(true, 'Job created successfully');
    }

    public function customerJobDetails()
    {

        // $headers =  'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'From: Waspsrats <info@waspsrats.com>' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        // if(mail('abdulmanan4d@gmail.com', 'subject', 'wasprats', $headers)) {
        // echo 'yes';
        // } else {
        // echo 'no';
        // }

         //dd('hello1');

        $customer = Customer::where('uuid', \request()->customer_id)->first();
        $schedule = ScheduleJob::with(['customer', 'invoice', 'services', 'schedule.user'])->where('customer_id', $customer->id)->get();
        $taxes = Tax::get();
        $tax_rate = $taxes[0]->rate;

        return DataTables::of($schedule)
            ->addColumn('service_name', function ($data) {
                return $data->services->name;
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
                return $data->services->service_amount;

        /*->addColumn('total', function ($data) {
                if ($data->invoice) {
                    return $data->invoice->total;
                } else {
                    return 0;
                }*/
            })->addColumn('tax', function ($data) use ($tax_rate) {
                return $tax_rate;
            })
            ->addColumn('total_amount', function ($data) {
                return amountWithTax($data->services->id);
            })
            ->addColumn('action', function ($customer) {

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

    public function customersJobsInvoices(Request $request)
    {
        $tax = Tax::where('is_active',1)->value('rate');
        $dateFilter = json_decode(request()->extra_search);
        // dd($dateFilter);
        // $tab = 'all';
        // if (!empty($dateFilter->customer_id)) {
        //     $tab = 'customer';
        // }
        // if(!empty($dateFilter->start_date)){
        //     $tab = 'date';
        // }
        // if (!empty($dateFilter->user_tech_id)) {
        //     $tab = 'technician';
        // }

        if ($request->ajax()) {
            $startDate = $dateFilter->start_date;
            $endDate = $dateFilter->end_date;
            $customerId = $dateFilter->customer_id;
            $userTechId = $dateFilter->user_tech_id;
             $schedule = ScheduleJob::has('payments')->with(['customer.service_payments', 'services.service_payment', 'schedule.user', 'payments'])

                                        ->when(!empty($dateFilter->customer_id) && $dateFilter->customer_id != "null", function ($q) use($customerId) {
                                            return $q->where('customer_id', $customerId);
                                        })
                                        ->when(!empty($dateFilter->start_date), function ($q) use($startDate, $endDate) {
                                            return $q->whereDate('created_at', '>=', Carbon::parse($startDate)->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::parse($endDate)->format('Y-m-d'));
                                        })
                                        ->when(!empty($dateFilter->user_tech_id) && $dateFilter->user_tech_id != "null", function ($q) use($userTechId) {
                                            return $q->whereHas('schedule',function($q) use($userTechId) {
                                                $q->where('user_id',$userTechId);
                                            });
                                        });
            //  $schedule = ScheduleJob::with(['customer.service_payments', 'services.service_payment', 'schedule.user']);
            //  switch ($tab) {
            //     case 'customer':
            //         $schedule->where('customer_id', $dateFilter->customer_id);
            //         break;
            //     case 'date':
            //         $schedule->whereDate('created_at', '>=', Carbon::parse($dateFilter->start_date)->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::parse($dateFilter->end_date)->format('Y-m-d'));
            //         break;
            //     case 'technician':
            //     $value = $dateFilter->user_tech_id;
            //      $schedule->whereHas('schedule',function($q) use($value) {
            //         $q->where('user_id',$value);
            //     });
            //         break;
            //     default:
            //         $schedule;
            //         break;
            // }
        return DataTables::of($schedule)
                ->addColumn('payments', function ($product) {
                    return '<span class="details-control"></span>';
                })
            ->addColumn('technician_name', function ($data) {
                if ($data->schedule->user) {
                    return $data->schedule->user->name;
                } else {
                    return $data->schedule->name;
                }
            })
            /*->addColumn('payment_status', function ($data) use ($tax) {
                 if((int) $data->services->service_amount + $tax < (int)($data->customer->service_payments)->sum('amount')) {
                    return "Fully Paid";
                 }else {
                    return "Partial Paid";
                 }

            })*/
            ->addColumn('status', function ($data) {
                    return $data->status;
            })
            ->addColumn('amount', function ($data) {
                return $data->services->service_amount;
            })
             ->addColumn('created_at', function ($data) {
                    return $data->created_at;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->rawColumns(['action', 'payments'])
            ->make(true);
        }
            $customers = Customer::orderBy('created_at','desc')->get(['id','first_name','last_name']);
            $getTechnicians = User::whereHas('roles', function($role) {$role->where('name','Technician');
                    })->get();
        return view('customers.customers-jobs-invoices',compact('customers','getTechnicians'));
    }
}
