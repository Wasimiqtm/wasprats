<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\ItemRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Industry;
use App\Models\Item;
use App\Models\Tax;
use App\Models\Timezone;
use Session;
use DataTables;
use Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Item::with('tax1', 'tax2');
            $user = Auth::user();
            
            return Datatables::of($items)
                ->addColumn('is_active', function ($item) {
                    return getStatusBadge($item->is_active);
                })
                ->addColumn('action', function ($item) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Items Update')) {
                        $action .= '<a href="'.route('items.edit', $item->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Items Delete')) {    
                        $action .= '<a href="'.route('items.destroy', $item->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = Tax::pluck('name', 'id')->prepend('Select Tax', '');
        return view('items.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        Item::create($request->validated());

        Session::flash('success', __('Item successfully added!'));
        return redirect()->route('items.index');
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
     * @param  \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $taxes = Tax::pluck('name', 'id')->prepend('Select Tax', '');
        return view('items.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ItemRequest  $request
     * @param  \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Item $item, ItemRequest $request)
    {
        $item->update($request->validated());
        
        Session::flash('success', __('Item successfully updated!'));
        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
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
}
