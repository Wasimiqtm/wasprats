<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model
{
    use HasFactory;

    protected $table ='service_payments';
    protected $guarded =['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class,'job_id','id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }

}
