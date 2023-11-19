<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;
    protected $table='estimates';
    protected $guarded=['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($estimate) {
            $estimate->uuid = 'INV-' . strtoupper(uniqid());
        });
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }
    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
