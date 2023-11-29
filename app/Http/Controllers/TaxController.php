<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TaxRequest;
use App\Models\Tax;

use Session;
use DataTables;
use Auth;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $taxes = Tax::query();
            $user = Auth::user();
            
            return Datatables::of($taxes)
                ->addColumn('is_active', function ($tax) {
                    return getStatusBadge($tax->is_active);
                })
                ->addColumn('action', function ($tax) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Taxes Update')) {
                        $action .= '<a href="'.route('taxes.edit', $tax->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Taxes Delete')) {    
                        $action .= '<a href="'.route('taxes.destroy', $tax->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('taxes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taxes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TaxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxRequest $request)
    {
        Tax::create($request->validated());

        Session::flash('success', __('Tax successfully added!'));
        return redirect()->route('taxes.index');
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
     * @param  \App\Models\Tax $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        return view('taxes.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaxRequest  $request
     * @param  \App\Models\Tax $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Tax $tax, TaxRequest $request)
    {
        $tax->update($request->validated());
        
        Session::flash('success', __('Tax successfully updated!'));
        return redirect()->route('taxes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        if ($tax) {
            $tax->delete();
            return response()->json([
                'message' => __('Tax deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Tax not exist against this id')
        ], $this->errorStatus);
    }
}
