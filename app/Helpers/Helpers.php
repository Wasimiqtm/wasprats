<?php

use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\District;
use App\Models\SMSLog;
use App\Models\Logs;
use App\Models\Service;

/**
 * Encode Id
 *
 * @param $id
 * @return mix
 */
if (!function_exists('encodeId')) {

    function encodeId($id)
    {
        return Hashids::encode($id);
    }

}

/**
 * Image Decode
 *
 * @param $fileName
 * @return mix
 */
if (!function_exists('imageNameDecode')) {

    function imageNameDecode($fileName)
    {

        $firstStr = str_replace("twiiiyui=", "==", $fileName);
        $secondStr = base64_decode($firstStr);
        return str_replace('rootidr', "", $secondStr);
    }

}

/**
 * Decode Id
 *
 * @param $id
 * @return mix
 */
if (!function_exists('decodeId')) {

    function decodeId($id)
    {
        $ids = Hashids::decode($id);
        if (count($ids) > 0) {
            return $ids[0];
        }

        return 0;
    }

}

/**
 * Get NFS Path
 *
 * @param $directory
 * @param $public_path
 * @return mix
 */
if (!function_exists('get_nfs_path')) {

    function get_nfs_path($directory = '', $public_path = false)
    {
        $directory = 'uploads/cepris-uploads/' . $directory;
        $path = asset($directory . '/');
        if ($public_path) {
            $path = public_path($directory . '/');
        }

//        if (in_array(config('app.env'), array('staging'))) {
//            $path = '/NFS-DATA/' . $directory . '/';
//        }
        return $path;
    }

}

/**
 * Upload Image
 *
 * @param $image
 * @param $dir
 * @return mix
 */
if (!function_exists('uploadImage')) {

    function uploadImage($image, $dir = '')
    {
        try {
            $name = time() . '.' . $image->getClientOriginalExtension();
            $newName = md5(rand(0, 100000) . strtotime(date('Y-m-d H:i:s') . microtime())) . $name;
            $destinationPath = get_nfs_path($dir, true);
            $image->move($destinationPath, $newName);
            return $newName;
        } catch (Exception $e) {
            Log::error('Image Upload Error: ' . $e->getMessage());
            return '';
        }
    }

}

/**
 * Read file data
 *
 * @param $directory
 * @param $fileName
 * @return mix
 */
if (!function_exists('read_file')) {

    function read_file($directory = false, $fileName = false, $link = true)
    {
        if (!$fileName || !$directory) {
            return false;
        }

//        if (in_array(config('app.env'), array('staging'))) {
//            $imgString = str_replace("==", "twiiiyui=", base64_encode(get_nfs_path($directory) . $fileName));
//            if (strpos($fileName, '.pdf')) {
//                return route('display-pdf', $imgString);
//            } else {
//                return route('display-image', $imgString);
//            }
//        } else {
        if (strpos($fileName, '.pdf') && !$link) {
            return asset('images/1200px-PDF_file_icon.png');
        } else {
            return URL::to(get_nfs_path($directory) . '/' . $fileName);
        }
        //}
    }

}

/**
 * Get Admin Data
 *
 * @return mix
 */
if (!function_exists('getAdmin')) {

    function getAdmin()
    {
        return User::where('email', config('app.admin_email'))->first();
    }

}

/**
 * Check Active Route
 *
 * @param $route
 * @param $output
 * @return mix
 */
if (!function_exists('isActiveRoute')) {

    function isActiveRoute($route, $output = "active")
    {
        if (Route::current()->uri == $route)
            return $output;
    }

}

/**
 * Active Route
 *
 * @param $paths
 * @param $class
 * @return mix
 */
if (!function_exists('setActive')) {

    function setActive($paths, $class = TRUE, $className = 'menu-item-active')
    {
        foreach ($paths as $path) {

            if (Request::is($path . '*')) {
                if ($class)
                    return ' class=menu-item-active';
                else
                    return ' ' . $className;
            }
        }
    }

}

/**
 * Active Routes
 *
 * @param $routes
 * @param $output
 * @return mix
 */
if (!function_exists('areActiveRoutes')) {

    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::current()->uri == $route) {
                return $output;
            }
        }
    }

}

/**
 * Send Message to Mobile Number
 *
 * @param $number
 * @param $message
 * @return mix
 */
if (!function_exists('sendOtpMessage')) {

    function sendOtpMessage($number, $otp, $cnic = '')
    {
        $message = __('messages.your_otp_is', ['otp' => $otp]);
        sendSms($number, $message, $cnic, 'otp');
    }

}

/**
 * Send Message to Mobile Number
 *
 * @param $number
 * @param $message
 * @return mix
 */
if (!function_exists('sendPasswordMessage')) {

    function sendPasswordMessage($number, $password, $cnic = '')
    {
        $message = __('messages.your_password_is', ['password' => $password]);
        sendSms($number, $message, $cnic, 'password');
    }

}

/**
 * Send Message to Mobile Number
 *
 * @param $number
 * @param $message
 * @return mix
 */
if (!function_exists('sendSms')) {

    function sendSms($number, $message, $cnic = null, $type = null, $logId = 0)
    {

        $twoDigit = substr($number, 0, 2);
        if ($twoDigit != 92) {
            $number = '92' . substr($number, 1);
        }

        $request = [
            'ContactNumber' => $number,
            'SmsContent' => $message,
            'LogId' => $logId,
            'SecurityKey' => config('app.sms_key')
        ];

        $smsLog = SMSLog::create([
            'cnic' => $cnic,
            'mobile' => $number,
            'request' => json_encode($request),
            'request_time' => date('Y-m-d H:i:s'),
            'type' => $type
        ]);

        if ($logId > 0) {
            // log step 12
            saveLogs([
                'log_id' => $logId,
                'sms_status' => 0,
                'sms_request' => json_encode($request),
                'sms_request_time' => date('Y-m-d H:i:s'),
                'status' => 12
            ]);
        }

        Log::channel('sms')->info('PSPA SMS Request Data: ' . json_encode($request));

        try {
            $response = Http::post(config('app.sms_url'), $request);

            $resData = $response->object();

            $smsLog->response = $response->json();
            $smsLog->response_time = date('Y-m-d H:i:s');


            if (isset($resData) && $resData->Message == "Success") {
                $smsStatus = 1;
            } else {
                $smsStatus = 2;
            }

            $smsLog->status = $smsStatus;
            $smsLog->save();

            if ($logId > 0) {
                // log step 13
                saveLogs([
                    'log_id' => $logId,
                    'sms_status' => $smsStatus,
                    'sms_response' => $response->json(),
                    'sms_response_time' => date('Y-m-d H:i:s'),
                    'status' => 13
                ]);
            }

            Log::channel('sms')->info('PSPA SMS Response: ', $response->json());

            return true;

        } catch (Exception $e) {
            Log::channel('sms')->error('SMS Error: ' . $e->getMessage());

            $smsRes = json_encode([
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
            ]);

            $smsLog->response = $smsRes;
            $smsLog->response_time = date('Y-m-d H:i:s');
            $smsLog->status = 2;
            $smsLog->save();

            if ($logId > 0) {
                // log step 14
                saveLogs([
                    'log_id' => $logId,
                    'sms_status' => 2,
                    'sms_response' => $smsRes,
                    'sms_response_time' => date('Y-m-d H:i:s'),
                    'status' => 14
                ]);
            }

            return false;
        }
    }

}

/**
 * Save log data in database
 *
 * @param Array $logData
 * @return mix
 */
if (!function_exists('saveLogs')) {

    function saveLogs($logData = [])
    {

        if (@$logData['log_id'] > 0) {

            //Logs::where('id', $logData['log_id'])->update($logData);

            $log = Logs::find($logData['log_id']);
            if ($log) {
                $log->update($logData);
                //$log = $log->fresh();
                return $log;
            }
        } else if (isset($logData['cnic']) && isset($logData['mobile'])) {
            $cnic = $logData['cnic'];
            $number = $logData['mobile'];

            if (isset($logData['request_from_pspa'])) {
                $log = Logs::create([
                    'cnic' => $cnic,
                    'mobile' => $number,
                    'request_from_pspa' => $logData['request_from_pspa'],
                    'request_from_pspa_time' => date('Y-m-d H:i:s')
                ]);

                //$log = $log->fresh();
                return $log;
            }
        }

        return false;
    }

}

/**
 * Hide Digits
 *
 * @param $number
 * @param $hideStart
 * @param $hideEnd
 * @param $showCharacter
 * @return mix
 */
if (!function_exists('hideDigits')) {

    function hideDigits($number, $hideStart = 0, $hideEnd = 0, $showCharacter = '*')
    {
        return substr($number, 0, $hideStart) . str_pad('', (strlen($number) - $hideStart - $hideEnd), $showCharacter) . substr($number, -$hideEnd);
    }

}

/**
 * Get Role Name
 *
 * @return mix
 */
if (!function_exists('roleName')) {

    function roleName()
    {
        $roleName = '';
        $user = Auth::user();
        if (@$user->getRoleNames()->first()) {
            $roleName = $user->getRoleNames()->first();
        }

        return $roleName;
    }

}

/**
 * Get Role Name
 *
 * @return mix
 */
if (!function_exists('isSuperAdmin')) {

    function isSuperAdmin()
    {
        $isSuperAdmin = false;
        $user = Auth::user();
        if (@$user->getRoleNames()->first() && $user->getRoleNames()->first() == 'Super Admin') {
            $isSuperAdmin = true;
        }

        return $isSuperAdmin;
    }

}

/**
 * Get Application Status Badge
 *
 * @param $status
 * @return mix
 */
if (!function_exists('getStatusBadge')) {

    function getStatusBadge($status = 1)
    {
        $badge = '<span style="overflow: visible; position: relative; width: 130px;">';

        switch ($status) {
            case 1:
                $badge .= '<a href="#" class="badge bg-success" > Active </a>';
                break;
            default:
                $badge .= '<a href="#" class="badge bg-danger" > In Active </a>';
        }

        $badge .= '</span>';
        return $badge;
    }

}

/**
 * Get Excepts Array
 * @param $key
 * @return mix
 */
if (!function_exists('getExceptsArray')) {

    function getExceptsArray($key = 0, $secKey = '')
    {
        $excepts['except_1'] = [1 => 'the 1st', 2 => 'the 2nd', 3 => 'the 3rd', 4 => 'the 4th'];
        $excepts['except_2'] = [1 => 'Mon of', 2 => 'Tue of', 3 => 'Wed of', 4 => 'Thu of', 5 => 'Fri of', 6 => 'Sat of', 7 => 'Sun of'];
        $excepts['except_3'] = [1 => 'every week', 2 => 'every month'];

        if ($key > 0 && $key <= 3) {
            if (!empty($secKey) && $secKey > 0) {
                return $excepts['except_' . $key][$secKey];
            } else {
                return '';
            }
            return isset($excepts['except_' . $key]) ? $excepts['except_' . $key] : '';
        }

        return $excepts;
    }

}

/**
 * Get Uuid
 *
 * @return mix
 */
if (!function_exists('getUuid')) {

    function getUuid()
    {
        //(string) \Uuid::generate(4);
        return \DB::raw('uuid()');
    }

}

/**
 * Append an ordinal indicator to a numeric value.
 *
 * @param string|int $value
 * @param bool $superscript
 * @return string
 */
if (!function_exists('str_ordinal')) {

    function str_ordinal($value, $superscript = false)
    {
        $number = abs($value);

        $indicators = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }

        return number_format($number) . $suffix;
    }
}

/**
 * Get District List
 *
 * @param $status
 * @return mix
 */
if (!function_exists('getDistrictList')) {

    function getDistrictList($prepend = [])
    {
        $districts = District::pluck('name', 'id');
        return (empty($prepend)) ? $districts : $districts->prepend($prepend, '');
    }
}

/**
 * Get Company List
 *
 * @param $prepend
 * @return mix
 */
if (!function_exists('getCompanyList')) {

    function getCompanyList($prepend = [])
    {
        $companies = Company::pluck('name', 'id');
        return empty($prepend) ? $companies : $companies->prepend($prepend, '');
    }
}

/**
 * Get Customer List
 *
 * @param $prepend
 * @return mix
 */
if (!function_exists('getCustomerList')) {

    function getCustomerList($prepend = [])
    {
        $customers = [];
        //$customers = Customer::pluck('name', 'id');
        return empty($prepend) ? $customers : $customers->prepend($prepend, '');
    }
}

/**
 * Get Service List
 *
 * @param $prepend
 * @return mix
 */
if (!function_exists('getServiceList')) {

    function getServiceList($prepend = [])
    {
        $services = Service::pluck('name', 'id');
        return empty($prepend) ? $services : $services->prepend($prepend, '');
    }
}

/**
 * Get Country List
 *
 * @param $prepend
 * @return mix
 */
if (!function_exists('getCountryList')) {

    function getCountryList($prepend = [])
    {
        $countries = Country::pluck('name', 'id');
        return empty($prepend) ? $countries : $countries->prepend($prepend, '');
    }
}

/**
 * dd with json
 *
 * @return mix
 */
if (!function_exists('dj')) {

    function dj($data)
    {
        return response()->json([
            'data' => $data
        ], 200);
        exit;
    }

}

/**
 * Success Response
 *
 * @param $message
 * @return JSON
 */
if (!function_exists('successResponse')) {
    function successResponse($message, $response = [])
    {
        $responseData = [
            'message' => $message,
            'code' => 200,
            'status' => true,
        ];

        $response = array_merge($responseData, $response);

        return response()->json($response, 200);
    }
}

/**
 * Error Response
 *
 * @param $message
 * @return JSON
 */
if (!function_exists('errorResponse')) {
    function errorResponse($message, $response = [], $status = 400)
    {
        $responseData = [
            'message' => $message,
            'code' => $status,
            'status' => false,
        ];

        $response = array_merge($responseData, $response);

        return response()->json($response, 200);
    }

}

function load_pdf($pdf)
{
    header('Content-Type: application/pdf');
    $image_name = image_name_decode($pdf);
    readfile($image_name);
}

/**
 * add Dashes In CNIC
 *
 * @return mix
 */
if (!function_exists('addDashesInCNIC')) {

    function addDashesInCNIC($cnic)
    {
        return preg_replace("/^(\d{5})(\d{7})(\d{1})$/", "$1-$2-$3", $cnic);
    }

}

/**
 * add Dash In Mobile
 *
 * @return mix
 */
if (!function_exists('addDashInMobile')) {

    function addDashInMobile($mobile)
    {
        return preg_replace("/^(\d{4})(\d{7})$/", "$1-$2", $mobile);
    }

}

/**
 * getEventObject
 *
 * @param $job
 * @return JSON
 */
if (!function_exists('getEventObject')) {
    function getEventObject($job)
    {

        return [
            'id' => $job->id,
            // 'title' =>  @$job->customer->name . '<br>' . @$job->service->name,
            'title' => @$job->customer->name . ' - ' . @$job->service->name,
            'start' => \Carbon\Carbon::parse($job->date)->format('Y-m-d') . 'T' . \Carbon\Carbon::parse($job->times)->format('H:i:s'),
            'end' =>  \Carbon\Carbon::parse($job->date)->format('Y-m-d') . 'T' . \Carbon\Carbon::parse($job->times)->format('H:i:s'),
            'borderColor' => '#04a9f5',
            'backgroundColor' => @$job->services->color_code,
            'textColor' => '#000000',
            'classNames' => 'job-event-' . $job->id,
            'time' => date("h:i a", strtotime($job->date)) . '-' . date("h:i a", strtotime($job->time))
        ];
    }

}

if (!function_exists('getTags')) {
    function getTags()
    {
        return ['|FirstName|' => 'First Name', '|LastName|' => "Last Name"];
    }
}
if (!function_exists('getTemplateDate')) {
    function getTemplateDate($id)
    {
        switch ($id) {
            case '1':
                return [
                    'templateTitle' => 'Invoice Email',
                    'templateSubject' => "[::company_name::] Invoice [::invoice_number::].",
                    "templateBody" => "Please review the attached pdf invoice [::invoice_number::][::client_last_name::]
Thank you,
[::company_name::]
[::company_phone::]
[::company_email::][::client_first_name::]"
                ];
                break;
            case '2':
                return [
                    'templateTitle' => 'Invoice: Request E-Signature',
                    'templateSubject' => "[::company_name::] Invoice.",
                    "templateBody" => "Hi,

[::company_name::] has sent you a invoice to sign.

[::preview_sign_invoice::]

[::company_name::]
[::company_phone::]
[::company_email::]"
                ];
        }
    }
}
