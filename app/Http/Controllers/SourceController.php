<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SourceRequest;
use App\Models\Source;

use Session;
use DataTables;
use Auth;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sources = Source::query();
            $user = Auth::user();
            
            return Datatables::of($sources)
                ->addColumn('is_active', function ($source) {
                    return getStatusBadge($source->is_active);
                })
                ->addColumn('action', function ($source) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Sources Update')) {
                        $action .= '<a href="'.route('sources.edit', $source->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Sources Delete')) {    
                        $action .= '<a href="'.route('sources.destroy', $source->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('sources.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SourceRequest $request)
    {
        Source::create($request->validated());

        Session::flash('success', __('Source successfully added!'));
        return redirect()->route('sources.index');
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
     * @param  \App\Models\Source $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        return view('sources.edit', compact('source'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SourceRequest  $request
     * @param  \App\Models\Source $source
     * @return \Illuminate\Http\Response
     */
    public function update(Source $source, SourceRequest $request)
    {
        $source->update($request->validated());
        
        Session::flash('success', __('Source successfully updated!'));
        return redirect()->route('sources.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        if ($source) {
            $source->delete();
            return response()->json([
                'message' => __('Source deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Source not exist against this id')
        ], $this->errorStatus);
    }
}
