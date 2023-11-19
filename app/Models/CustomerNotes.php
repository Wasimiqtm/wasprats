<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotes extends Model
{
    use HasFactory;
    protected $table='customer_notes';
    protected $guarded =['id'];

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }


}
