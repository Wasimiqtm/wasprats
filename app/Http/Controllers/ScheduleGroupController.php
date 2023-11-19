<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ScheduleGroupRequest;
use App\Models\ScheduleGroup;
use Session;
use DataTables;
use Auth;

class ScheduleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $groups = ScheduleGroup::query();
            $user = Auth::user();
            
            return Datatables::of($groups)
                ->addColumn('is_active', function ($group) {
                    return getStatusBadge($group->is_active);
                })
                ->addColumn('action', function ($role) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Schedule Groups Update')) {
                        $action .= '<a href="'.route('schedule-groups.edit', $role->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Schedule Groups Delete')) {    
                        $action .= '<a href="'.route('schedule-groups.destroy', $role->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('schedule.schedule-groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule.schedule-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ScheduleGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleGroupRequest $request)
    {
        ScheduleGroup::create($request->validated());

        Session::flash('success', __('Group successfully added!'));
        return redirect()->route('schedule-groups.index');
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
     * @param  \App\Models\ScheduleGroup $group
     * @return \Illuminate\Http\Response
     */
    public function edit(ScheduleGroup $group)
    {
        return view('schedule.schedule-groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ScheduleGroupRequest  $request
     * @param  \App\Models\ScheduleGroup $group
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleGroup $group, ScheduleGroupRequest $request)
    {
        $group->update($request->validated());
        
        Session::flash('success', __('Group successfully updated!'));
        return redirect()->route('schedule-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\ScheduleGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScheduleGroup $group)
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
