<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $fillable = [
        'name',
        'nickname',
        'user_id',
        'start',
        'end',
        'start_lat',
        'start_lng',
        'end_lat',
        'end_lng',
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

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function schedule_groups () {
        return $this->hasMany(ScheduleGroupSchedule::class);
    }

    public function schedule_jobs()
    {
        return $this->hasMany(ScheduleJob::class);
    }
}
