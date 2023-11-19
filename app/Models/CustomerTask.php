<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTask extends Model
{
    use HasFactory;
    protected $table ='customer_tasks';
    protected $guarded =['id'];

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
