<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleJob extends Model
{
    use HasFactory;

    protected $table ='schedule_jobs';
    protected $guarded =['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class,'job_id','id');
    }

    public function services()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
