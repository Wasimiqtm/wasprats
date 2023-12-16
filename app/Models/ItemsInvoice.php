<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsInvoice extends Model
{
    protected $fillable = [
        'schedule_job_id',
        'used_items_id',
        'quantity'
    ];

    public function schedule_job()
    {
        return $this->belongsTo(ScheduleJob::class);
    }

    public function used_items()
    {
        return $this->belongsTo(UsedItem::class);
    }
}
