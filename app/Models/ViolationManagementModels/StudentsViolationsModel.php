<?php

namespace App\Models\ViolationManagementModels;

use Illuminate\Database\Eloquent\Model;

class StudentsViolationsModel extends Model
{
    protected $table = 'tbl_students_violations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'sid',
        'vid',
        'date_issued',
        'fee',
        'status',
        'area_code',
        'college_id',
        'course_id',
        'organization_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
