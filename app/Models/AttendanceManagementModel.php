<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceManagementModel extends Model
{
    protected $table = 'tbl_attendance_management';
    protected $primaryKey = 'id';
    protected $foreignKey = 'student_id';
    protected $foreignKeys = 'event_id';
    protected $fillable = [
        'id',
        'student_qrcode',
        'student_rfid',
        'student_id',
        'event_id',
        'attendance_date',
        'am_in',
        'am_out',
        'pm_in',
        'pm_out',
        'fees',
        'area_code',
        'college_id',
        'organization_id',
        'created_at',
        'updated_at',
        'deleted_at'

    ];
}
