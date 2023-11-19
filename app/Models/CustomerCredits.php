<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCredits extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    protected $table='payments';

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
