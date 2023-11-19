<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleGroupSchedule extends Model
{
    
    protected $fillable = [
        'schedule_group_id',
        'schedule_id'
    ];
}
