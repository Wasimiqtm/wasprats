<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = [
        'name',
        'service_amount',
        'hours',
        'minutes',
        'repeat',
        'repeat_every',
        'repeat_on_1',
        'repeat_on_2',
        'repeat_on_3',
        'repeat_on_4',
        'repeat_on_5',
        'repeat_on_6',
        'repeat_on_7',
        'repeat_by',
        'ends',
        'ends_after_jobs',
        'ends_on',
        'except_1',
        'except_2',
        'except_3',
        'job_status',
        'color_code',
        'invoice_sub_total',
        'invoice_tax',
        'invoice_discount',
        'invoice_total_discount',
        'invoice_total',
        'invoice_terms',
        'invoice_note',
        'estimate_sub_total',
        'estimate_tax',
        'estimate_discount',
        'estimate_total_discount',
        'estimate_total',
        'estimate_terms',
        'estimate_note',
        'is_active'
    ];

    /**
     * @return void
     */
    public function getExceptCompletedAttribute()
    {
        $exceptCompleted = '';
        if ($this->repeat != 'Not') {
            $exceptCompleted = getExceptsArray(1, $this->except_1) . ' ' . getExceptsArray(2, $this->except_2) . ' ' . getExceptsArray(3, $this->except_3);
        }
        return $exceptCompleted;
    }

    /**
     * @return void
     */
    public function getLengthCompletedAttribute()
    {
        $length = ($this->hours>0) ? $this->hours . ' hours' : '';
        $length .= ($this->hours>0 && $this->minutes>0) ? ' & ' : '';
        $length .= ($this->minutes>0) ? $this->minutes . ' minutes' : '';

        return $length;
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
     * Get all of the items for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice_items()
    {
        return $this->hasMany(ServiceInvoiceItem::class, 'service_id');
    }

    /**
     * Get all of the items for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estimate_items()
    {
        return $this->hasMany(ServiceEstimateItem::class, 'service_id');
    }

    public function schedule_job()
    {
        return $this->hasMany(ScheduleJob::class);
    }
    public function service_payment()
    {
        return $this->hasMany(ServicePayment::class,'service_id','id');
    }
}
