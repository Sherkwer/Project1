<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsManagementModel extends Model
{
    protected $table = 'tbl_events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'event_name',
        'schedule',
        'sy',
        'term',
        'venue',
        'am_in',
        'am_out',
        'pm_in',
        'pm_out',
        'description',
        'fee_perSession',
        'status',
    ];
}
