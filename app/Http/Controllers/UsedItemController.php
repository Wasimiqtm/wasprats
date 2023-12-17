<?php

namespace App\Http\Controllers;

use App\Models\ItemsInvoice;
use App\Models\ScheduleJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UsedItemRequest;
use App\Models\UsedItem;

use Session;
use DataTables;
use Auth;

class UsedItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $usedItems = UsedItem::query()->latest();
            $user = Auth::user();

            return Datatables::of($usedItems)
                ->addColumn('action', function ($item) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('usedItems Update')) {
                        $action .= '<a href="'.route('things.edit', $item->id).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('usedItems Delete')) {
                        $action .= '<a href="'.route('things.destroy', $item->id).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('used-items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('used-items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsedItemRequest $request)
    {
        UsedItem::create($request->validated());

        Session::flash('success', __('Item successfully added!'));
        return redirect()->route('things.index');
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
     * @param  \App\Models\UsedItem $item
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        $item = UsedItem::find($item);
        return view('used-items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UsedItemRequest  $request
     * @param  \App\Models\UsedItem $item
     * @return \Illuminate\Http\Response
     */
    public function update($item, UsedItemRequest $request)
    {
        $item = UsedItem::find($item);
        $item->update($request->validated());

        Session::flash('success', __('Item successfully updated!'));
        return redirect()->route('things.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsedItem $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        $item = UsedItem::find($item);
        if ($item) {
            $item->delete();
            return response()->json([
                'message' => __('Item deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Item not exist against this id')
        ], $this->errorStatus);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemsInvoice(Request $request, $scheduleJobId)
    {
        if ($request->ajax()) {
            $itemsInvoice = ItemsInvoice::with('schedule_job.services', 'used_items')->where(['schedule_job_id' => $scheduleJobId]);
            return Datatables::of($itemsInvoice)
                ->addColumn('service_name', function ($itemInvoice) {
                    return $itemInvoice->schedule_job->services->name;
                })
                ->addColumn('code', function ($itemInvoice) {
                    return $itemInvoice->used_items->code;
                })
                ->addColumn('quantity', function ($itemInvoice) {
                    return $itemInvoice->quantity;
                })
                ->addColumn('action', function ($itemInvoice) {
                    $action = '<td><div class="overlay-edit">';
                    $action .= '<a href="javascript:void(0)" id="updateinvoice" data-id="' . $itemInvoice->id . '" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                        $action .= '<a href="'.route('delete.item.invoice', $itemInvoice->id).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                /*->editColumn('created_at', function (ServicePayment $servicePayment) {
                    return \Carbon\Carbon::parse($servicePayment->created_at )->isoFormat('DD-MM-YYYY');
                })*/
                ->rawColumns(['action'])
                ->make(true);
        }

        $items = UsedItem::pluck('code', 'id')->prepend('Select Item', '');
        $job = ScheduleJob::with('services')->whereId($scheduleJobId)->first();
        return view('used-items.items-invoices.index', compact('scheduleJobId', 'items', 'job'));
    }

    public function createItemsInvoice()
    {
        $data = request()->all();
        $dataFind = [];

        foreach ($data['item_id'] as $key=>$value){
            $dataFind[] = [
                'schedule_job_id' => $data['schedule_job_id'],
                'used_items_id' => $value,
                'quantity' => $data['item_quantity'][$key]
            ];
        }
        if($data['item_invoice_id'])
        {
            ItemsInvoice::whereId($data['item_invoice_id'])
                ->update([
                    'used_items_id' => $dataFind[0]['used_items_id'],
                    'quantity' => $dataFind[0]['quantity'],
                ]);
        } else {
            foreach ($dataFind as $value){
                ItemsInvoice::create([
                    'schedule_job_id' => $value['schedule_job_id'],
                    'used_items_id' => $value['used_items_id'],
                    'quantity' => $value['quantity']
                ]);
            }
        }
        return ['status' => true];
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function usedItemsList()
    {
        $items = UsedItem::pluck('code', 'id')->prepend('Select Item', '');
        return [
            'success' => true,
            'html' => view('used-items.partial.item-row', get_defined_vars())->render()
        ];
    }

    public function getEditItemsInvoice()
    {
        $itemsInvoiceData = ItemsInvoice::with('schedule_job.services', 'used_items')->whereId(\request()->id)->first();
        return ['data' => $itemsInvoiceData];
    }

    public function deleteItemInvoice($item)
    {
        $item = ItemsInvoice::find($item);
        if ($item) {
            $item->delete();
            return response()->json([
                'message' => __('Item deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Item not exist against this id')
        ], $this->errorStatus);
    }

    public function getSingleItem(Request $request)
    {
        $result = UsedItem::find($request->id);
        return $result;
    }

    public function printItemsInvoice($scheduleJobId)
    {
        $currentTime = Carbon::now();
        $fileName =  $currentTime->toDateTimeString();
        $printInvoice = ItemsInvoice::with('schedule_job.services', 'used_items')->where('schedule_job_id', $scheduleJobId)->get();
        return view('used-items.partial.print_invoice', compact('printInvoice'));
    }
}
