<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'guard_name'
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
