<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\CustomerLocation;
use Session;
use DataTables;
use Auth;

class CustomerLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $customerId = null)
    {
        $customer = Customer::uuid($customerId)->first();
        if ($request->ajax()) {
            $customers = CustomerLocation::where('customer_id', $customer->id);
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

                    if ($user->can('Customer Locations Update')) {
                        $action .= '<a href="'.route('customer-locations.edit', $customer->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Customer Locations Delete')) {    
                        $action .= '<a href="'.route('customer-locations.destroy', $customer->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        } else {
            // if (!$request->filled('id')) {
            //     return redirect()->route('customers.index');
            // }
        }
        
        $tab = 'locations';

        return view('customer-locations.index', get_defined_vars());
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
        return view('customer-locations.create', get_defined_vars());
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
            'name' => 'required|max:50',
            'street' => 'required|max:100',
            'city' => 'required|max:30',
            'state' => 'required|max:30',
            'zip' => 'required|max:30',
            'latitude' => 'nullable|max:30',
            'longitude' => 'nullable|max:30',
            'is_active' => 'required|in:0,1'
        ]);

        CustomerLocation::create($request->all());

        Session::flash('success', __('Customer location successfully added!'));
        return redirect()->route('customers.locations', [$request->uuid]);
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
        $location = CustomerLocation::uuid($uuid)->first();
        $customer = Customer::find($location->customer_id);

        return view('customer-locations.edit', get_defined_vars());
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
            'name' => 'required|max:50',
            'street' => 'required|max:100',
            'city' => 'required|max:30',
            'state' => 'required|max:30',
            'zip' => 'required|max:30',
            'latitude' => 'nullable|max:30',
            'longitude' => 'nullable|max:30',
            'is_active' => 'required|in:0,1'
        ]);

        $location = CustomerLocation::uuid($uuid)->first();
        $location->update($request->all());
        $customer = Customer::find($location->customer_id);

        Session::flash('success', __('Customer location successfully updated!'));
        return redirect()->route('customers.locations', [$customer->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $location = CustomerLocation::uuid($uuid)->first();
        if ($location) {
            $location->delete();
            return response()->json([
                'message' => __('Customer location deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Customer location not exist against this id')
        ], $this->errorStatus);
    }
}
