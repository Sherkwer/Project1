<?php

namespace App\Models\SystemSettingsModel;

use Illuminate\Database\Eloquent\Model;

class ManageCollegeModel extends Model
{
    protected $table = 'db_colleges';
    protected $fillable = [
        'id',
        'area_code',
        'name',
        'prefix',
        'head_officer',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'
    ];

}
