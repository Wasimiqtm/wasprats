<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerContactController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\TimezoneController;
use App\Http\Controllers\RoleGroupController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleGroupController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UsedItemController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CustomerLocationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SystemSmsController;
use \App\Http\Controllers\ReportController;
use \App\Http\Controllers\PaymentsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    return "All cache cleared";
});

Route::redirect('/', 'dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::resource('jobs', JobController::class);
    Route::post('update-job', [JobController::class, 'updateJob'])->name('update-job');

    Route::get('customers-jobs-invoices', [JobController::class, 'customersJobsInvoices'])->name('customers.jobs.invoices');
    Route::POST('customers-jobs-invoices',[JobController::class, 'customersJobsInvoices'])->name('customers.jobs.invoices.ajax');

    Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('users.change-password');

    Route::resource('users', UserController::class);
    Route::post('users/ajax', [UserController::class, 'index'])->name('users.ajax');
    Route::any('users-get-active-jobs', [UserController::class, 'getJobsDetails'])->name('users.get.active.jobs');
    Route::get('job-invoice/{user_id}', [UserController::class, 'jobInvoice'])->name('job.invoice');

    /*list payments technician*/
    Route::get('get-technician-amount/{user_id}', [UserController::class, 'getTechnicianAmount'])->name('technician.amount');
    Route::post('get-technician-amount/{user_id}', [UserController::class, 'getTechnicianAmount'])->name('technician.amount.ajax');

    Route::resource('customers', CustomerController::class);
    Route::post('customers/ajax', [CustomerController::class, 'index'])->name('customers.ajax');

    Route::resource('customer-contacts', CustomerContactController::class);
    Route::post('customer-contacts/ajax', [CustomerContactController::class, 'index'])->name('customer-contacts.ajax');

    Route::get('customer-jobs/{customer_id}', [JobController::class, 'index'])->name('customers.jobs');
    Route::post('customer-jobs/{customer_id}', [JobController::class, 'index'])->name('customers.jobs.ajax');

    Route::get('customer-details/{customer_id}/{type}', [CustomerController::class, 'getCustomerDetails'])->name('customers.details');
    Route::POST('customer-type', [CustomerController::class, 'getTypeData'])->name('customers.type');
    Route::POST('customers-notes', [CustomerController::class, 'addCustomerNotes'])->name('customers.notes');


    Route::POST('customers-tasks', [CustomerController::class, 'addCustomerTasks'])->name('customers.tasks');
    Route::POST('customers-tasks-edit', [CustomerController::class, 'getEditTaskData'])->name('customers.tasks.edit');
    Route::POST('customers-tasks-complete', [CustomerController::class, 'completeTask'])->name('customers.tasks.complete');
    Route::POST('customers-tasks-delete', [CustomerController::class, 'deleteTask'])->name('customers.tasks.delete');

    Route::POST('customer-invoices', [CustomerController::class, 'customerInvoices'])->name('customers.invoices');
    Route::POST('customers-invoices-details', [CustomerController::class, 'getCustomerInvoices'])->name('customers.invoices.details');

    Route::POST('customer-estimates', [CustomerController::class, 'customerEstimates'])->name('customers.estimates');
    Route::POST('customer-estimates-details-list', [CustomerController::class, 'customerEstimatesDetails'])->name('customers.estimates.details.list');

    Route::resource('customer-locations', CustomerLocationController::class)->except('show');
    Route::post('customer-locations/ajax/{customer_id}', [CustomerLocationController::class, 'index'])->name('customer-locations.ajax');
    Route::get('customer-locations/{customer_id}', [CustomerLocationController::class, 'index'])->name('customers.locations');


    Route::resource('companies', CompanyController::class);
    Route::post('companies/ajax', [CompanyController::class, 'index'])->name('companies.ajax');

    Route::resource('schedule-groups', ScheduleGroupController::class);
    Route::post('schedule-groups/ajax', [ScheduleGroupController::class, 'index'])->name('schedule-groups.ajax');
    Route::resource('schedules', ScheduleController::class);
    Route::post('schedules/ajax', [ScheduleController::class, 'index'])->name('schedules.ajax');
    Route::post('schedules/re-assign', [ScheduleController::class, 'reAssignSchedule'])->name('schedules.reAssign');

    Route::resource('items', ItemController::class);
    Route::post('items/ajax', [ItemController::class, 'index'])->name('items.ajax');

    Route::resource('taxes', TaxController::class);
    Route::post('taxes/ajax', [TaxController::class, 'index'])->name('taxes.ajax');

    Route::resource('used-items', UsedItemController::class)->names('things');
    Route::post('used-items/ajax', [UsedItemController::class, 'index'])->name('things.ajax');

    Route::resource('methods', MethodController::class);
    Route::post('methods/ajax', [MethodController::class, 'index'])->name('methods.ajax');

    Route::resource('sources', SourceController::class);
    Route::post('sources/ajax', [SourceController::class, 'index'])->name('sources.ajax');

    Route::resource('services', ServiceController::class)->except('show');
    Route::post('services/ajax', [ServiceController::class, 'index'])->name('services.ajax');

    Route::get('services/get-item-row', [ServiceController::class, 'getItemRow'])->name('services.getItemRow');
    Route::get('services/get-item-details/{item_id}', [ServiceController::class, 'getItemDetails'])->name('services.getItemDetails');
    Route::patch('update-service-invoice', [ServiceController::class, 'updateInvoice'])->name('services.updateInvoice');
    Route::patch('update-service-estimate', [ServiceController::class, 'updateEstimate'])->name('services.updateEstimate');

    Route::resource('tags', TagController::class);
    Route::post('tags/ajax', [TagController::class, 'index'])->name('tags.ajax');

    Route::resource('industries', IndustryController::class);
    Route::post('industries/ajax', [IndustryController::class, 'index'])->name('industries.ajax');

    Route::resource('countries', CountryController::class);
    Route::post('countries/ajax', [CountryController::class, 'index'])->name('countries.ajax');

    Route::resource('currencies', CurrencyController::class);
    Route::post('currencies/ajax', [CurrencyController::class, 'index'])->name('currencies.ajax');

    Route::resource('timezones', TimezoneController::class);
    Route::post('timezones/ajax', [TimezoneController::class, 'index'])->name('timezones.ajax');

    # ACL
    Route::resource('role-groups', RoleGroupController::class);
    Route::post('role-groups/ajax', [RoleGroupController::class, 'index'])->name('role-groups.ajax');

    Route::resource('roles', RoleController::class);
    Route::post('roles/ajax', [RoleController::class, 'index'])->name('roles.ajax');
    Route::get('roles/permissions/{role}', [RoleController::class, 'getRolePermissions'])->name('roles.getPermissions');
    Route::put('roles/permissions/{role}', [RoleController::class, 'updateRolePermission'])->name('roles.permissions');

    Route::resource('permissions', PermissionController::class);
    Route::post('permissions/ajax', [PermissionController::class, 'index'])->name('permissions.ajax');

    Route::get('settings/{page?}', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::POST('get-template',[SystemSmsController::class,'getTemplate'])->name('get.template');
    Route::GET('custom-sms',[SystemSmsController::class,'getCustomSms'])->name('custom.sms');
    Route::post('custom-sms-ajax', [SystemSmsController::class, 'getCustomSms'])->name('custom.sms.ajax');
    Route::resource('system-email',SystemSmsController::class);

    Route::get("customers-report",[ReportController::class,'getCustomerReport'])->name('customers.report');
    Route::POST("customers-report-details",[ReportController::class,'getCustomerReportDetails'])->name('customers.report.details');

    Route::get('invoices',[ReportController::class, 'getAllInvoices'])->name('invoices');
    Route::POST('invoice-details',[ReportController::class, 'invoiceList'])->name('invoice.details');

    Route::get('customers-estimates-details',[ReportController::class,'customersEstimatesDetails'])->name('customers.estimates.details');
    Route::POST('estimate-details',[ReportController::class, 'estimateList'])->name('estimate.details');
    Route::POST('customer-credits',[CustomerController::class, 'customerCredits'])->name('customer.credits');
    Route::POST('customers-credit-details-list',[CustomerController::class, 'getCustomerCreditList'])->name('customers.credit.details.list');
    Route::GET('invoice-credits',[ReportController::class, 'getInvoiceCredits'])->name('invoice.credits');
    Route::POST('invoice-credit-list',[ReportController::class, 'getInvoiceCreditsList'])->name('invoice.credit.list');
    Route::POST('get-customer-list',[CustomerController::class, 'getCustomerList'])->name('get.customer.list');
    Route::POST('service-info',[ServiceController::class, 'getServiceInfo'])->name('service.info');
    Route::POST('job-assign',[JobController::class, 'assignJob'])->name('job.assign');
    Route::POST('customers-job-details',[JobController::class, 'customerJobDetails'])->name('customers.job.details');
    Route::POST('update-customer-job',[JobController::class, 'updateCustomerJobStatus'])->name('update.customer.job');
//    Route::resource('payments', PaymentsController::class);

    /*list payments against service*/
    Route::get('service-payment/{service_id}', [PaymentsController::class, 'index'])->name('service.payments');
    Route::post('service-payment/{service_id}', [PaymentsController::class, 'index'])->name('service.payments.ajax');
    Route::post('add-service-payment',[PaymentsController::class, 'addServicePayment'])->name('add.service.payment');
    Route::get('amount-invoice/{service_id}', [PaymentsController::class, 'amountInvoice'])->name('amount.invoice');
    Route::get('payment-invoice/{service_payment_id}', [PaymentsController::class, 'singlePaymentInvoice'])->name('single.payment.invoice');
});
Route::get('/export-csv', [ReportController::class,'getCustomerReportExport']);
Route::get('/export-invoice', [ReportController::class,'exportInvoiceDetails']);
Route::get('export-credits', [ReportController::class,'exportCreditDetails'])->name('export.credits');

require __DIR__.'/auth.php';
