<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting;

use Session;
use Auth;

class SettingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = 'index')
    {
        $settings = Setting::pluck('value', 'key');
        return view('settings.' . $page, get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $settings = $request->setting;

        if ($request->type == 'templates') {
            if (!$request->filled('setting.location_address_name')) {
                $settings['location_address_name']  = 'hide';
            }
            if (!$request->filled('setting.display_payment_method')) {
                $settings['display_payment_method']  = 'hide';
            }
            if (!$request->filled('setting.check_in_out')) {
                $settings['check_in_out']  = 'hide';
            }
            if (!$request->filled('setting.service_date')) {
                $settings['service_date']  = 'hide';
            }
            if (!$request->filled('setting.next_service_date')) {
                $settings['next_service_date']  = 'hide';
            }
            if (!$request->filled('setting.weather')) {
                $settings['weather']  = 'hide';
            }
        }

        foreach($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        

        Session::flash('success', __('Setting successfully updated!'));
        return redirect()->route('settings.index', $request->type);
    }
}
