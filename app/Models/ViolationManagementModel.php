<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViolationManagementModel extends Model
{
    protected $table = 'tbl_violations';
    protected $fillable = [
        'id',
        'vname',
        'date_implemented',
        'fee',
        'description',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
