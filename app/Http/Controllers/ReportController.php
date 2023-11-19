<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerCredits;
use App\Models\Estimate;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function getCustomerReport()
    {
        $lineData = $this->currentMonths();
        $data = [];
        foreach ($lineData as $value) {
            $data[] = Customer::whereMonth('created_at', Carbon::parse($value)->month)->count();
        }
        $data = collect($data);
        return view('reports.customer_reports', compact('data'));
    }

    public function currentMonths()
    {
        $months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;

        $monthNames = [];

        for ($i = 0; $i < $currentMonth; $i++) {
            $monthNames[] = $months[$i];
        }

        return $monthNames;
    }

    public function getCustomerReportDetails()
    {
        $dateFilter = json_decode(request()->extra_search);

        $customers = Customer::whereDate('created_at', '>=', Carbon::parse($dateFilter->start_date)->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::parse($dateFilter->end_date)->format('Y-m-d'))->get();
        return DataTables::of($customers)
            ->addColumn('action', function ($user) {

            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getCustomerReportExport(Request $request)
    {
        $fileName = 'cutomers.csv';
        $customers = Customer::get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Title', 'Assign', 'Description');

        $callback = function () use ($customers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($customers as $task) {
                $row['Title'] = $task->name;
                $row['Assign'] = $task->phone;
                $row['Description'] = $task->email;


                fputcsv($file, array($row['Title'], $row['Assign'], $row['Description']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getAllInvoices()
    {
        return view('reports.customer_invoices');
    }

    public function invoiceList()
    {
        $dateFilter = json_decode(request()->extra_search);

        $customers = Invoice::with('customers')->whereDate('created_at', '>=', Carbon::parse($dateFilter->start_date)->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::parse($dateFilter->end_date)->format('Y-m-d'))->get();
        return DataTables::of($customers)
            ->addColumn('customer', function ($user) {
                return $user->customers->first_name . '' . $user->customers->last_name;
            })
            ->addColumn('billing_email', function ($user) {
                return $user->customers->email;
            })->addColumn('invoice_date', function ($user) {
                return Carbon::parse($user->created_at)->format('m/d/Y');
            })->addColumn('status', function ($user) {
                return $user->status;
            })
            ->addColumn('total', function ($user) {
                return $user->discount_type . '' . $user->total;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function exportInvoiceDetails()
    {
        $fileName = 'invoice.csv';
        $customers = Invoice::with('customers')->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Customer', 'Billing Email', 'Date','Total');

        $callback = function () use ($customers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($customers as $user) {
                $row['customer'] = $user->customers->first_name . '' . $user->customers->last_name;;
                $row['billing_email'] = $user->customers->email;
                $row['invoice_date'] = Carbon::parse($user->created_at)->format('m/d/Y');;
                $row['total'] = $user->discount_type . '' . $user->total;


                fputcsv($file, array($row['customer'], $row['billing_email'], $row['invoice_date'],$row['total']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function customersEstimatesDetails()
    {
        return view('reports.customer_estimates');
    }

    public function estimateList()
    {
        $dateFilter = json_decode(request()->extra_search);

        $customers = Estimate::with('customers')->whereDate('created_at', '>=', Carbon::parse($dateFilter->start_date)->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::parse($dateFilter->end_date)->format('Y-m-d'))->get();
        return DataTables::of($customers)
            ->addColumn('customer', function ($user) {
                return $user->customers->first_name . '' . $user->customers->last_name;
            })
            ->addColumn('billing_email', function ($user) {
                return $user->customers->email;
            })->addColumn('invoice_date', function ($user) {
                return Carbon::parse($user->created_at)->format('m/d/Y');
            })->addColumn('status', function ($user) {
                return $user->status;
            })
            ->addColumn('total', function ($user) {
                return $user->discount_type . '' . $user->total;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getInvoiceCredits()
    {
        return view('reports.invoice_credits');
    }

    public function getInvoiceCreditsList()
    {
        $dateFilter = json_decode(request()->extra_search);

        $customers = CustomerCredits::with('customers')->whereDate('created_at', '>=', Carbon::parse($dateFilter->start_date)->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::parse($dateFilter->end_date)->format('Y-m-d'))->get();
        return DataTables::of($customers)
            ->addColumn('customer', function ($user) {
                return $user->customers->first_name . '' . $user->customers->last_name;
            })
            ->addColumn('method',function ($row){
                if(in_array($row->payment_method,['cash','check'])){
                    return $row->payment_method.'/'.$row->extra_info;
                }
                return $row->payment_method;
            })->addColumn('dated', function ($row) {
                return Carbon::parse($row->date)->format('m/d/Y');
            })
            ->addColumn('total',function ($row){
                return '$'.$row->amount;
            })
            ->make(true);
    }

    public function exportCreditDetails()
    {
        $fileName = 'invoice.csv';
        $customers = CustomerCredits::with('customers')->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Customer', 'Method', 'Date','Total');

        $callback = function () use ($customers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($customers as $user) {
                $row['customer'] = $user->customers->first_name . '' . $user->customers->last_name;;
                $row['method'] = (in_array($row->payment_method,['cash','check']))?  $user->payment_method.'/'.$user->extra_info: $user->payment_method;
                $row['date'] = Carbon::parse($user->date)->format('m/d/Y');;
                $row['total'] = '$'.$user->amount;;


                fputcsv($file, array($row['customer'], $row['method'], $row['date'],$row['total']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
