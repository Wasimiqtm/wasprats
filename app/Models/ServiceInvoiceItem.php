<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceInvoiceItem extends Model
{
    
    protected $fillable = [
        'service_id',
        'item_id',
        'cost',
        'quantity',
        'tax_id_1',
        'tax_id_2',
        'total_cost'
    ];
}
