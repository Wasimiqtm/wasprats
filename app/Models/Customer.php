<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [
        'first_name',
        'last_name',
        'account_no',
        'email',
        'company_name',
        'phone',
        'is_active'
    ];

    protected $appends = ['name'];

    /**
     * @return void
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

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
     * Get all of the jobs for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function customer_notes()
    {
        return $this->hasMany(CustomerNotes::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function credits()
    {
        return $this->hasMany(CustomerCredits::class);
    }

    public function schedule_jobs()
    {
        return $this->hasMany(ScheduleJob::class);
    }
    public function service_payments()
    {
        return $this->hasMany(ServicePayment::class,'customer_id', 'id');
    }
}
