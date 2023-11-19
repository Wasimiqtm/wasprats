<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'fax',
        'license',
        'country_id',
        'city',
        'state',
        'zip',
        'address',
        'opening_time',
        'closing_time',
        'industry_id',
        'timezone_id',
        'currency_id',
        'date_format',
        'temperature',
        'website',
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
}
