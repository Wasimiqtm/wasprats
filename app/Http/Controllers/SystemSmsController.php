<?php

namespace App\Http\Controllers;

use App\Models\SmsEmails;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SystemSmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SmsEmails::whereType('default')->get();
        return view('settings.system_emails.system_email', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTemplate()
    {
        return SmsEmails::find(\request()->id);

    }

    public function getCustomSms(Request $request)
    {
        if ($request->ajax()) {
            $data = SmsEmails::whereType('custom')->get();

            return DataTables::of($data)
                ->addColumn('is_active', function ($item) {
                    return getStatusBadge($item->is_active);
                })
                ->addColumn('action', function ($item)  {

                    $action = '<td><div class="overlay-edit">';


                        $action .= '<a href=" " class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';

                    $action .= '</div></td>';

                    return $action;
                })
                ->rawColumns([ 'action'])
                ->make(true);
        }

        return view('settings.system_emails.custom-sms');
    }
}
