<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\MethodRequest;
use App\Models\Method;

use Session;
use DataTables;
use Auth;

class MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $methods = Method::query();
            $user = Auth::user();
            
            return Datatables::of($methods)
                ->addColumn('is_active', function ($method) {
                    return getStatusBadge($method->is_active);
                })
                ->addColumn('action', function ($method) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Methods Update')) {
                        $action .= '<a href="'.route('methods.edit', $method->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Methods Delete')) {    
                        $action .= '<a href="'.route('methods.destroy', $method->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('methods.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MethodRequest $request)
    {
        Method::create($request->validated());

        Session::flash('success', __('Method successfully added!'));
        return redirect()->route('methods.index');
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
     * @param  \App\Models\Method $method
     * @return \Illuminate\Http\Response
     */
    public function edit(Method $method)
    {
        return view('methods.edit', compact('method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MethodRequest  $request
     * @param  \App\Models\Method $method
     * @return \Illuminate\Http\Response
     */
    public function update(Method $method, MethodRequest $request)
    {
        $method->update($request->validated());
        
        Session::flash('success', __('Method successfully updated!'));
        return redirect()->route('methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method $method
     * @return \Illuminate\Http\Response
     */
    public function destroy(Method $method)
    {
        if ($method) {
            $method->delete();
            return response()->json([
                'message' => __('Method deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Method not exist against this id')
        ], $this->errorStatus);
    }
}
