<?php

namespace App\Models\SystemSettingsModel;

use Illuminate\Database\Eloquent\Model;

class ManageProgramsModel extends Model
{

    protected $table = 'db_courses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'area_code',
        'status',
        'code',
        'name',
        'college_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'
    ];

}
