<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Industry;
use App\Models\Timezone;
use Session;
use DataTables;
use Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companies = Company::query();
            $user = Auth::user();
            
            return Datatables::of($companies)
                ->addColumn('is_active', function ($company) {
                    return getStatusBadge($company->is_active);
                })
                ->addColumn('action', function ($company) use ($user) {
                    $action = '<span style="overflow: visible; position: relative; width: 130px;">';
                    //if($user->hasrole('Super Admin') || $user->can('Edit Divisions'))
                        //$action .= '<a href="'. route('companies.edit', $company->uuid) .'" data-edit="true" class="text-primary me-2" data-toggle="tooltip" title="'.__('Edit Company').'"><i class="feather icon-edit"></i></a>';
                    //if($user->hasrole('Super Admin') || $user->can('Delete Divisions'))
                        $action .= '<a href="'. route('companies.destroy', $company->uuid) .'" class="text-danger btn-delete" data-toggle="tooltip" title="'.__('Delete Company').'"><i class="feather icon-trash-2"></i></a>';
                      
                    $action .= '</span>';    
                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industries = Industry::orderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Industry', '');
        $timezones = Timezone::orderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Timezone', '');
        $countries = Country::orderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Country', '');
        $currencies = Currency::orderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Currency', '');
        $dateFormats = ['mm-dd-yyyy', 'dd-mm-yyyy'];
        $temperatures = ['Fahrenheit (F)'];

        return view('companies.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        Company::create($request->all());

        Session::flash('success', __('Company successfully added!'));
        return redirect()->route('companies.index');
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
     * @param  App\Models\Company;
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CompanyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Company $company, CompanyRequest $request)
    {
        $company->update($request->validated());
        
        Session::flash('success', __('Company successfully updated!'));
        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if ($company) {
            $company->delete();
            return response()->json([
                'message' => __('Company deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Company not exist against this id')
        ], $this->errorStatus);
    }
}
