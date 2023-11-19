<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $successStatus = 200;
    public $errorStatus = 401;

    public function sendResponse($success = true, $message = '', $data = [], $code = 200)
    {
        
        $response = [
            'success' => $success,
            'code'    => $code, 
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $code);
    }
}
