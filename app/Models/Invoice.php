<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table='invoices';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $invoice->invoice_id = 'INV-' . strtoupper(uniqid());
        });
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    public function schedule_jobs()
    {
        return $this->belongsTo(ScheduleJob::class,'job_id','id');
    }

}
