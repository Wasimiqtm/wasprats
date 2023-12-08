<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

use App\Http\Requests\RoleRequest;
use App\Http\Requests\ServiceRequest;
use App\Models\Item;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceEstimateItem;
use App\Models\ServiceInvoiceItem;
use App\Models\Tax;
use Session;
use DataTables;
use Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::query();
            $user = Auth::user();

            return Datatables::of($services)
                ->addColumn('length_completed', function ($service) {
                    return $service->length_completed;
                })
                ->addColumn('except_completed', function ($service) {
                    return $service->except_completed;
                })
                ->addColumn('is_active', function ($service) {
                    return getStatusBadge($service->is_active);
                })
                ->addColumn('action', function ($service) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Services Update')) {
                        $action .= '<a href="'.route('services.edit', $service->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Services Delete')) {
                        //$action .= '<a href="'.route('services.destroy', $service->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        for($i = 0; $i<=10; $i++) {
            $lengthHours[$i] = $i . ' hours';
        }
        for($i = 0; $i<60; $i+=5) {
            $lengthMinutes[$i] = $i . ' minutes';
        }
        for($i = 0; $i<=10; $i++) {
            $repeatEvery[$i] = $i;
        }//

        $repeat = ['Not' => 'Does not repeat', 'Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly', 'Yearly' => 'Yearly'];
        $excepts = getExceptsArray();

        return view('services.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        Service::create($request->all());

        Session::flash('success', __('Service successfully added!'));
        return redirect()->route('services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        for($i = 0; $i<=10; $i++) {
            $lengthHours[$i] = $i . ' hours';
        }
        for($i = 0; $i<60; $i+=5) {
            $lengthMinutes[$i] = $i . ' minutes';
        }
        for($i = 0; $i<=10; $i++) {
            $repeatEvery[$i] = $i;
        }

        $repeat = ['Not' => 'Does not repeat', 'Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly', 'Yearly' => 'Yearly'];
        $excepts = getExceptsArray();
        //dd($service->invoice_items->toArray());

        if (in_array(request()->tab, ['invoice', 'estimate'])) {
            $items = Item::pluck('name', 'id')->prepend('Select Item', '');
            $taxes = Tax::get();
        }

        return view('services.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ServiceRequest  $request
     * @param  \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(Service $service, ServiceRequest $request)
    {
//        dd($request->all());
        $service->update($request->validated());

        Session::flash('success', __('Service successfully updated!'));
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        // if ($service) {
        //     $service->delete();
        //     return response()->json([
        //         'message' => __('Service deleted!')
        //     ], $this->successStatus);
        // }

        return response()->json([
            'message' => __('Service not exist against this id')
        ], $this->errorStatus);
    }

   /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getItemRow()
    {
        $items = Item::pluck('name', 'id')->prepend('Select Item', '');
        $taxes = Tax::get();
        return [
            'success' => true,
            'html' => view('services.partial.item-row', get_defined_vars())->render()
        ];
    }

    /**
     * Get Item Details
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getItemDetails($id)
    {
        $item = Item::find($id);
        if ($item) {
            return [
                'success' => true,
                'item' => $item
            ];
        }

        return ['success' => false];
    }

    /**
     * Update Service Invoice
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateInvoice(Request $request)
    {
        //dd($request->all());
        $service = Service::find($request->id);
        if ($service) {

            ServiceInvoiceItem::where('service_id', $service->id)->delete();

            $subTotal = $tax = $discount = $total = 0;
            foreach($request->item_id as $key => $itemId) {
                $item = Item::find($itemId);
                if ($item) {

                    $cost = isset($request->item_cost[$key]) ? $request->item_cost[$key] : 0;
                    $quantity = isset($request->item_quantity[$key]) ? $request->item_quantity[$key] : 0;

                    $serviceInvoiceItem = [
                        'service_id' => $service->id,
                        'item_id' => $item->id,
                        'cost' => $cost,
                        'quantity' => $quantity
                    ];

                    $taxRate = 0;
                    if (isset($request->item_tax_1[$key])) {
                        $tax1Id = $request->item_tax_1[$key];
                        $tax1 = Tax::find($tax1Id);
                        if ($tax1) {
                            $taxRate = $taxRate + $tax1->rate;
                            $serviceInvoiceItem['tax_id_1'] = $tax1->id;
                        }
                    }
                    if (isset($request->item_tax_2[$key])) {
                        $tax2Id = $request->item_tax_2[$key];
                        $tax2 = Tax::find($tax2Id);
                        if ($tax2) {
                            $taxRate = $taxRate + $tax2->rate;
                            $serviceInvoiceItem['tax_id_2'] = $tax2->id;
                        }
                    }

                    $totalCost = ($cost * $quantity);
                    $serviceInvoiceItem['total_cost'] = $totalCost;
                    $subTotal = $subTotal + $totalCost;

                    if ($taxRate > 0) {
                        $tax = $tax + (($totalCost * $taxRate) / 100);
                    }

                    ServiceInvoiceItem::create($serviceInvoiceItem);
                }
            }

            if ($request->discount_type == '$' && $request->discount > 0) {
                $discount = $request->discount;
            } else if ($request->discount_type == '%' && $request->discount > 0) {
                $discount = ($subTotal * $request->discount) / 100;
            }

            $total = $subTotal - $discount + $tax;

            $service->invoice_sub_total = $subTotal;
            $service->invoice_tax = $tax;
            $service->invoice_discount_type = $request->discount_type;
            $service->invoice_discount = $request->filled('discount') ? $request->discount : 0;
            $service->invoice_total_discount = $discount;
            $service->invoice_total = $total;
            $service->invoice_terms = $request->term;
            $service->invoice_note = $request->note;
            $service->save();

            return ['success' => true, 'message' => 'Service invoice successfully updated' ];
        }

        return ['success' => false];
    }

    /**
     * Update Service Estimate
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateEstimate(Request $request)
    {
        $service = Service::find($request->id);
        if ($service) {

            ServiceEstimateItem::where('service_id', $service->id)->delete();

            $subTotal = $tax = $discount = $total = 0;
            foreach($request->item_id as $key => $itemId) {
                $item = Item::find($itemId);
                if ($item) {

                    $cost = isset($request->item_cost[$key]) ? $request->item_cost[$key] : 0;
                    $quantity = isset($request->item_quantity[$key]) ? $request->item_quantity[$key] : 0;

                    $serviceEstimateItem = [
                        'service_id' => $service->id,
                        'item_id' => $item->id,
                        'cost' => $cost,
                        'quantity' => $quantity
                    ];

                    $taxRate = 0;
                    if (isset($request->item_tax_1[$key])) {
                        $tax1Id = $request->item_tax_1[$key];
                        $tax1 = Tax::find($tax1Id);
                        if ($tax1) {
                            $taxRate = $taxRate + $tax1->rate;
                            $serviceEstimateItem['tax_id_1'] = $tax1->id;
                        }
                    }
                    if (isset($request->item_tax_2[$key])) {
                        $tax2Id = $request->item_tax_2[$key];
                        $tax2 = Tax::find($tax2Id);
                        if ($tax2) {
                            $taxRate = $taxRate + $tax2->rate;
                            $serviceEstimateItem['tax_id_2'] = $tax2->id;
                        }
                    }

                    $totalCost = ($cost * $quantity);
                    $serviceEstimateItem['total_cost'] = $totalCost;
                    $subTotal = $subTotal + $totalCost;

                    if ($taxRate > 0) {
                        $tax = $tax + (($totalCost * $taxRate) / 100);
                    }

                    ServiceEstimateItem::create($serviceEstimateItem);
                }
            }

            if ($request->discount_type == '$' && $request->discount > 0) {
                $discount = $request->discount;
            } else if ($request->discount_type == '%' && $request->discount > 0) {
                $discount = ($subTotal * $request->discount) / 100;
            }

            $total = $subTotal - $discount + $tax;

            $service->estimate_sub_total = $subTotal;
            $service->estimate_tax = $tax;
            $service->estimate_discount_type = $request->discount_type;
            $service->estimate_discount = $request->filled('discount') ? $request->discount : 0;
            $service->estimate_total_discount = $discount;
            $service->estimate_total = $total;
            $service->estimate_terms = $request->term;
            $service->estimate_note = $request->note;
            $service->save();

            return ['success' => true, 'message' => 'Service estimate successfully updated' ];
        }

        return ['success' => false];
    }

    public function getServiceInfo()
    {
        $services = Service::where('id',request()->id)->first();
        $schedules = Schedule::with('user')->get();
        // $getTechnicians = User::whereHas('roles', function($role) {$role->where('name','Technician');
                    // })->get();
        return view('customers.customer_details.services-details',compact('services','schedules'));
    }
}
