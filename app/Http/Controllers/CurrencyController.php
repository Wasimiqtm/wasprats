<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;

use Session;
use DataTables;
use Auth;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $currencies = Currency::query();
            $user = Auth::user();
            
            return Datatables::of($currencies)
                ->addColumn('is_active', function ($currency) {
                    return getStatusBadge($currency->is_active);
                })
                ->addColumn('action', function ($currency) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Currencies Update')) {
                        $action .= '<a href="'.route('currencies.edit', $currency->uuid).'" class="btn btn-icon btn-secondary"><i class="feather icon-edit-2"></i></a>';
                    }

                    if ($user->can('Currencies Delete')) {    
                        $action .= '<a href="'.route('currencies.destroy', $currency->uuid).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CurrencyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request)
    {
        Currency::create($request->validated());

        Session::flash('success', __('Currency successfully added!'));
        return redirect()->route('currencies.index');
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
     * @param  App\Models\Currency;
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CurrencyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Currency $currency, CurrencyRequest $request)
    {
        $currency->update($request->validated());
        
        Session::flash('success', __('Currency successfully updated!'));
        return redirect()->route('currencies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Industry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        if ($currency) {
            $currency->delete();
            return response()->json([
                'message' => __('Currency deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Currency not exist against this id')
        ], $this->errorStatus);
    }
}
