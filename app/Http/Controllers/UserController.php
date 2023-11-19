<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Schedule;
use App\Models\ScheduleJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Session;
use DataTables;
use Auth;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::query();
            $auth = Auth::user();

            return Datatables::of($users)
                ->addColumn('role', function ($user) {
                    return $user->getRoleNames()->first();
                })
                ->addColumn('action', function ($user) use ($auth) {

                    $action = '<td><div class="overlay-edit">';

                    if ($auth->can('Roles Update')) {
                        $action .= '<a href="'.route('users.edit', $user->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($auth->can('Roles Delete')) {
                        $action .= '<a href="'.route('users.destroy', $user->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    if( $user->getRoleNames()->first() ==='Technician') {
                        $action .= '<a href="' . route('users.get.active.jobs', ['id' =>$user->uuid,'type' =>'active']) . '" class="btn btn-icon btn btn-primary"><i class="feather icon-user-check"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->merge([
            'name' => $request->first_name . ' ' . $request->last_name,
            'password' => Hash::make($request->password)
        ]);
        $user = User::create($request->all());

        if ($user) {
            $role = Role::find($request->role_id);
            if ($role) {
                $user->assignRole($role);
            }
        }


        Session::flash('success', __('User successfully added!'));
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return view('users.user_detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\User;
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $role = $user->roles->first();

        $roles = Role::pluck('name', 'id');
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @param  App\Models\User
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UserRequest $request)
    {
        $data['name'] = $request->first_name . ' ' . $request->last_name;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            $request->request->remove('password');
        }

        $request->merge($data);

        if ($user) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $role = Role::find($request->role_id);
            if ($role) {
                $user->assignRole($role);
            }
            $user->update($request->all());

            Session::flash('success', __('Role successfully updated!'));
            return redirect()->route('users.index');
        }

        Session::flash('error', __('User not successfully updat!'));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->delete();
            return response()->json([
                'message' => __('User deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('User not exist against this id')
        ], $this->errorStatus);
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function changePassword()
    {
        return view('users.change-password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        $user = User::find(Auth::id());
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);

            Session::flash('success', __('Password successfully updated!'));
            return redirect()->route('change-password');
        }

        Session::flash('error', __('User not successfully updat!'));
        return redirect()->route('change-password');
    }

    public function getJobsDetails()
    {

        if(\request()->ajax()){

            $user = User::where('uuid',\request()->id)->first();

            $jobs = ScheduleJob::with(['services','customer'])->whereIn('schedule_id',$user->schedules->pluck('id'))->where('status',\request()->type)->get();

           return  Datatables::of($jobs)
                ->addColumn('service_name',function ($item){
                    return $item->services->name;
                })
                ->make(true);
        }
        return view('users.user_detail');
    }
}
