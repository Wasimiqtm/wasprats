<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'role_group_id',
        'guard_name',
    ];
    
    /**
     * belongs To relation RoleGroup
     */
    public function group () {
        return $this->belongsTo(RoleGroup::class, 'role_group_id');
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
}
