<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsedItem extends Model
{

    protected $table = 'used_items';

    protected $fillable = [
        'name',
        'code',
        'description'
    ];
}
