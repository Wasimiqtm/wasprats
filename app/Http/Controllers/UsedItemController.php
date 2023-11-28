<?php

namespace App\Http\Controllers;

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
}
