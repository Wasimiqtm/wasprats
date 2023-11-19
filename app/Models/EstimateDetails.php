<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateDetails extends Model
{
    use HasFactory;
    protected $table='estimate_details';
    protected $guarded=['id'];
}
