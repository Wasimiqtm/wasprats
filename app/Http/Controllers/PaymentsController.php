<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServicePayment;
use Illuminate\Http\Request;
use DataTables;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $serviceId)
    {
        $tab = 'active';
        if ($request->filled('tab') && in_array($request->tab, ['completed', 'canceled'])) {
            $tab = $request->tab;
        }

        if ($request->ajax()) {
            $services = ServicePayment::with('service', 'customer', 'user')->where('service_id', $serviceId);
            /*switch ($tab) {
                case 'full':
                    $services->where('payment_mode', 'full');
                    break;
                case 'canceled':
                    $jobs->where('status', 'canceled');
                    break;
                default:
                    $services->where('payment_mode', 'partial');
                    break;
            }*/

            return Datatables::of($services)
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        $service = Service::uuid($serviceId)->first();
        return view('services.payments', get_defined_vars());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
