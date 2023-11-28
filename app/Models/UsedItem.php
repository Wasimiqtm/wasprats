<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsedItem extends Model
{
    
    protected $table = 'used_items';

    protected $fillable = [
        'name'
    ];

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeId($query, $id)
    {
        dd($query, $id);
        return $query->where('id', $id);
    }
}
