<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsManagementModel extends Model
{
    protected $table = 'db_students';
    protected $primaryKey = 'id';
    protected $foreignKeys = [
        'area_code',
        'college_code',
        'course_code'
    ];

    protected $fillable = [
    'id',
    'sid',
    'lname',
    'fname',
    'mname',
    'fullname',
    'email',
    'rid',
    'area_code',
    'college_code',
    'organization_id',
    'course_code',
    'qr_code',
    'rfid',
    'year_level',
    'term',
    'sy',
    'password',
    'student_status',
    'enroll_status',
    'created_at',
    'updated_at',
    'deleted_at'
    ];
}
