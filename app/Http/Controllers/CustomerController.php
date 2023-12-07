<?php

namespace App\Http\Controllers;

use App\Models\CustomerCredits;
use App\Models\CustomerNotes;
use App\Models\CustomerTask;
use App\Models\Estimate;
use App\Models\EstimateDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Item;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\CustomerLocation;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\JobEmail;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use Session;
use DataTables;
use Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $customers = Customer::query()->latest();
            $user = Auth::user();

            return Datatables::of($customers)
                ->addColumn('name', function ($customer) {
                    return '<a class="btn" href="'.route('customers.details', ['customer_id' =>$customer->uuid,'type'=>'notes']).'">'.$customer->name.'</a>';
                })
                ->addColumn('is_active', function ($customer) {
                    return getStatusBadge($customer->is_active);
                })
                ->addColumn('action', function ($customer) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Customer Jobs Index')) {
                        $action .= '<a href="'.route('customers.jobs', $customer->uuid).'" class="btn btn-icon btn-secondary" title="Jobs"><i class="feather icon-watch"></i></a>';
                    }

                    if ($user->can('Customer Contacts Index')) {
                        $action .= '<a href="'.route('customer-contacts.index', ['id' => $customer->uuid]).'" class="btn btn-icon btn-success" title="Contacts"><i class="feather icon-credit-card"></i></a>';
                    }

                    if ($user->can('Customers Update')) {
                        $action .= '<a href="'.route('customers.edit', $customer->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Customers Delete')) {
                        $action .= '<a href="'.route('customers.destroy', $customer->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active','name', 'action'])
                ->make(true);
        }

        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());

        Session::flash('success', __('Customer successfully added!'));
        return redirect()->route('customers.index');
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
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $customer, CustomerRequest $request)
    {
        $customer->update($request->validated());

        Session::flash('success', __('Customer successfully updated!'));
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if ($customer) {
            $customer->delete();
            return response()->json([
                'message' => __('Customer deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Customer not exist against this id')
        ], $this->errorStatus);
    }

    public function getCustomerDetails($id)
    {
       $customer =  Customer::where('uuid',$id)->first();
        $customerNotes = CustomerNotes::with('customers')->whereCustomerId($customer->id)->orderBy('id','desc')->get();
        $users = User::get();
        $customerTask = CustomerTask::with('users')->whereCustomerId($customer->id)->orderBy(DB::raw('case when status= "pending" then 1 when status= "completed" then 2 end'))->get();
        $items = Item::pluck('name', 'id')->prepend('Select Item', '');
        $services = Service::all();

        $taxes = Tax::get();
        $customerLocation = CustomerLocation::where('customer_id',$customer->id )->orderBy('id','desc')->get();
        // $schedules = Schedule::with('user')->get();
        $getTechnicians = User::whereHas('roles', function($role) {$role->where('name','Technician');
                    })->get();
        return view('customers.details',compact('id','customerNotes','users','customerTask','items','taxes','services','customer','getTechnicians','customerLocation'));
    }

    public function addCustomerNotes()
    {
        $customer =  Customer::where('uuid', \request()->id)->first();
        $data = CustomerNotes::create([
            'customer_id' => $customer->id,
            'description' => \request()->notes
        ]);
        $customerNotes = CustomerNotes::with('customers')->whereCustomerId($customer->id)->orderBy('id','desc')->get();
        return view('customers.customer_details.notes',compact('customerNotes'));
    }

    public function addCustomerTasks()
    {

        $customer =  Customer::where('uuid', \request()->id)->first();
        $data = CustomerTask::updateOrCreate(['id' => \request()->task_id],[
            'customer_id' => $customer->id,
            'user_id' => \request()->user_id,
            'description' => \request()->task_name,
            'time' => \request()->time,
            'due_date' => \request()->dated,
            'status' => 'pending',
        ]);
        $users = User::get();
        $customerTask = CustomerTask::with('users')->whereCustomerId($customer->id)->orderBy(DB::raw('case when status= "pending" then 1 when status= "completed" then 2 end'))->get();
        return view('customers.customer_details.task',compact('customerTask','users'));
    }

    public function getTypeData()
    {
        $customer =  Customer::where('uuid', \request()->id)->first();
        $users = User::get();
        if(\request()->type=='notes'){
            $customerNotes = CustomerNotes::with('customers')->whereCustomerId($customer->id)->orderBy('id','desc')->get();
            return view('customers.customer_details.notes',compact('customerNotes'));
        }else{
            $customerTask = CustomerTask::with('users')->whereCustomerId($customer->id)->orderBy(DB::raw('case when status= "pending" then 1 when status= "completed" then 2 end'))->get();
            return view('customers.customer_details.task',compact('customerTask','users'));
        }
    }

    public function getEditTaskData()
    {
        $customerTask = CustomerTask::whereId(\request()->id)->first();
        return ['data' => $customerTask];
    }
    public function completeTask()
    {
        $customerTask = CustomerTask::whereId(\request()->id)->update([
            'status' => 'completed'
        ]);
        return ['data' => $customerTask];
    }
    public function deleteTask()
    {
        $customerTask = CustomerTask::whereId(\request()->id)->delete();
        return ['data' => $customerTask];
    }

    public function customerInvoices()
    {
        $data = request()->all();
        $dataFind = [];

        $subTotal = $tax = $discount = $total = 0;
        foreach ($data['item_id'] as $key=>$value){
            $cost = $data['item_cost'][$key];
            $quantity =  $data['item_quantity'][$key];

            $dataFind[]=['item_id' => $value,
                'quantity' => $data['item_quantity'][$key],
                'cost' => $data['item_cost'][$key],
                'tax_1' => $data['item_tax_1'][$key],
                'tax_2' => $data['item_tax_2'][$key],
                ];
            $taxRate = 0;
            if (isset($data['item_tax_2'][$key])) {
                $tax1Id = $data['item_tax_2'][$key];
                $tax1 = Tax::find($tax1Id);
                if ($tax1) {
                    $taxRate = $taxRate + $tax1->rate;

                }
            }
            if (isset($data['item_tax_1'][$key])) {
                $tax2Id = $data['item_tax_1'][$key];
                $tax2 = Tax::find($tax2Id);
                if ($tax2) {
                    $taxRate = $taxRate + $tax2->rate;

                }
            }
            $totalCost = ($cost * $quantity);

            $subTotal = $subTotal + $totalCost;

            if ($taxRate > 0) {
                $tax = $tax + (($totalCost * $taxRate) / 100);
            }


        }
        $customer =  Customer::where('uuid', \request()->customer_id)->first();
        $invoice = Invoice::create([
            'customer_id' =>$customer->id,
            'total' => $subTotal,
            'terms_condition' => $data['term'],
            'invoice_notes' => $data['note'],
            'tax_amount' => $tax,
            'discount_type' => $data['discount_type'],
        ]);

        foreach ($dataFind as $value){
            InvoiceDetail::create([
                'item_id' => $value['item_id'],
                'cost' => $value['cost'],
                'quantity' => $value['quantity'],
                'tax_1'  => $value['tax_1'],
                'tax_2'  => $value['tax_2'],
                'invoice_id' =>$invoice->id
            ]);
        }

    return ['status' => true];

    }

    public function getCustomerInvoices()
    {
        $customer =  Customer::where('uuid', \request()->customer_id)->first();
        return Datatables::of(Invoice::whereCustomerId($customer->id)->get())

            ->make(true);
    }


    public function customerEstimates()
    {
        $data = request()->all();
        $dataFind = [];

        $subTotal = $tax = $discount = $total = 0;
        foreach ($data['item_id'] as $key=>$value){
            $cost = $data['item_cost'][$key];
            $quantity =  $data['item_quantity'][$key];

            $dataFind[]=['item_id' => $value,
                'quantity' => $data['item_quantity'][$key],
                'cost' => $data['item_cost'][$key],
                'tax_1' => $data['item_tax_1'][$key],
                'tax_2' => $data['item_tax_2'][$key],
            ];
            $taxRate = 0;
            if (isset($data['item_tax_2'][$key])) {
                $tax1Id = $data['item_tax_2'][$key];
                $tax1 = Tax::find($tax1Id);
                if ($tax1) {
                    $taxRate = $taxRate + $tax1->rate;

                }
            }
            if (isset($data['item_tax_1'][$key])) {
                $tax2Id = $data['item_tax_1'][$key];
                $tax2 = Tax::find($tax2Id);
                if ($tax2) {
                    $taxRate = $taxRate + $tax2->rate;

                }
            }
            $totalCost = ($cost * $quantity);

            $subTotal = $subTotal + $totalCost;

            if ($taxRate > 0) {
                $tax = $tax + (($totalCost * $taxRate) / 100);
            }


        }
        $customer =  Customer::where('uuid', \request()->customer_id)->first();
        $estimate = Estimate::create([
            'customer_id' =>$customer->id,
            'total' => $subTotal,
            'terms_condition' => $data['term'],
            'invoice_notes' => $data['note'],
            'tax_amount' => $tax,
            'discount_type' => $data['discount_type'],
            'created_by' => auth()->user()->id
        ]);
        foreach ($dataFind as $value){
            EstimateDetails::create([
                'item_id' => $value['item_id'],
                'cost' => $value['cost'],
                'quantity' => $value['quantity'],
                'tax_1'  => $value['tax_1'],
                'tax_2'  => $value['tax_2'],
                'estimate_id' =>$estimate->id
            ]);
        }

        return ['status' => true];

    }

    public function customerEstimatesDetails()
    {
        $customer =  Customer::where('uuid', \request()->customer_id)->first();
        return Datatables::of(Estimate::whereCustomerId($customer->id)->get())

            ->make(true);
    }

    public function customerCredits()
    {
        $customer =  Customer::where('uuid', \request()->customer_id)->first();

        $data = [
            'customer_id' => $customer->id,
            'payment_method' => \request()->value1,
            'date' => \request()->dated,
            'amount' => \request()->amount,

        ];
        if(\request()->value1 ==='cash'){
            $data['extra_info'] = \request()->CustomerPayment_memo;
        }else if (\request()->value1 ==='check'){
            $data['extra_info'] =\request()->CustomerPayment_check_number;
        }
       $customerCredits =  CustomerCredits::create($data);
        return ['status' => true];
    }

    public function getCustomerCreditList()
    {
        $customer =  Customer::where('uuid', \request()->customer_id)->first();

        return Datatables::of(CustomerCredits::whereCustomerId($customer->id)->orderBy('created_at','desc')->get())
            ->addColumn('total',function ($row){
                return '$'.$row->amount;
            })->addColumn('method',function ($row){
                if(in_array($row->payment_method,['cash','check'])){
                    return $row->payment_method.'/'.$row->extra_info;
                }
                return $row->payment_method;
            })

            ->make(true);
    }

    public function getCustomerList()
    {
        dd(\request()->all());
    }


}
