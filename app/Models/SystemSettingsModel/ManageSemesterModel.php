<?php

namespace App\Models\SystemSettingsModel;

use Illuminate\Database\Eloquent\Model;

class ManageSemesterModel extends Model
{
    protected $table = 'db_periods';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'code',
        'name',
        'year',
        'term',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'

    ];

}
