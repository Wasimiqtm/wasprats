<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\CustomerContact;
use Session;
use DataTables;
use Auth;

class CustomerContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::where('uuid', $request->id)->first();
        if ($request->ajax()) {
            $customers = CustomerContact::where('customer_id', $customer->id);
            $user = Auth::user();
            
            return Datatables::of($customers)
                ->addColumn('name', function ($customer) {
                    return $customer->name;
                })
                ->addColumn('is_active', function ($customer) {
                    return getStatusBadge($customer->is_active);
                })
                ->addColumn('action', function ($customer) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Customer Contacts Update')) {
                        $action .= '<a href="'.route('customer-contacts.edit', $customer->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Customer Contacts Delete')) {    
                        $action .= '<a href="'.route('customer-contacts.destroy', $customer->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        } else {
            if (!$request->filled('id')) {
                return redirect()->route('customers.index');
            }
        }
        
        return view('customer-contacts.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!request()->filled('id')) {
            return redirect()->route('customers.index');
        }

        $customer = Customer::where('uuid', request()->id)->first();
        return view('customer-contacts.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'first_name' => 'required|max:50',
            'last_name' => 'nullable|max:50',
            'email' => 'nullable|max:50|email',
            'phone' => 'nullable|max:30',
            'is_active' => 'required|in:0,1'
        ]);

        CustomerContact::create($request->all());

        Session::flash('success', __('Customer contact successfully added!'));
        return redirect()->route('customer-contacts.index', ['id' => $request->uuid]);
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
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $contact = CustomerContact::uuid($uuid)->first();
        $customer = Customer::find($contact->customer_id);

        return view('customer-contacts.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update($uuid, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:50',
            'last_name' => 'nullable|max:50',
            'email' => 'nullable|max:50|email',
            'phone' => 'nullable|max:30',
            'is_active' => 'required|in:0,1'
        ]);

        $contact = CustomerContact::uuid($uuid)->first();
        $contact->update($request->all());
        $customer = Customer::find($contact->customer_id);

        Session::flash('success', __('Customer contact successfully updated!'));
        return redirect()->route('customer-contacts.index', ['id' => $customer->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $contact = CustomerContact::uuid($uuid)->first();
        if ($contact) {
            $contact->delete();
            return response()->json([
                'message' => __('Customer contact deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Customer contact not exist against this id')
        ], $this->errorStatus);
    }
}
