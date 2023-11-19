<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    protected $fillable = [
        'name',
        'description',
        'cost',
        'tax_1',
        'tax_2',
        'is_active'
    ];

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * boot
     */
    protected static function boot ()
    {
    	parent::boot();
        static::creating(function ($model) {
            $model->uuid = getUuid();
        });
    }

    public function tax1 () {
        return $this->belongsTo(Tax::class, 'tax_1');
    }
    
    public function tax2 () {
        return $this->belongsTo(Tax::class, 'tax_2');
    }
}
