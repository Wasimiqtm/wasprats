<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RoleGroupRequest;
use App\Models\RoleGroup;

use Session;
use DataTables;
use Auth;

class RoleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $groups = RoleGroup::query();
            $user = Auth::user();
            
            return Datatables::of($groups)
                ->addColumn('is_active', function ($group) {
                    return getStatusBadge($group->is_active);
                })
                ->addColumn('action', function ($group) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Role Groups Update')) {
                        $action .= '<a href="'.route('role-groups.edit', $group->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Role Groups Delete')) {    
                        $action .= '<a href="'.route('role-groups.destroy', $group->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('acl.role-groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('acl.role-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\RoleGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleGroupRequest $request)
    {
        RoleGroup::create($request->validated());

        Session::flash('success', __('Group successfully added!'));
        return redirect()->route('role-groups.index');
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
     * @param  App\Models\RoleGroup;
     * @return \Illuminate\Http\Response
     */
    public function edit(RoleGroup $group)
    {
        return view('acl.role-groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\RoleGroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleGroup $group, RoleGroupRequest $request)
    {
        $group->update($request->validated());
        
        Session::flash('success', __('Group successfully updated!'));
        return redirect()->route('role-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\RoleGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleGroup $group)
    {
        if ($group) {
            $group->delete();
            return response()->json([
                'message' => __('Group deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Group not exist against this id')
        ], $this->errorStatus);
    }
}
