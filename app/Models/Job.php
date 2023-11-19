<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    
    protected $fillable = [
        'customer_id',
        'service_id',
        'from_date',
        'from_time',
        'to_date',
        'to_time',
        'status'
    ];

    protected $dates = ['from_date', 'from_time', 'to_date', 'to_time'];

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

    /**
     * Get the customer that owns the Job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the service that owns the Job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
