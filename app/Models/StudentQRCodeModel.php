<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQRCodeModel extends Model
{
    protected $table = 'tbl_students_qrcode';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'student_qrcode',
        'student_id',
        'fullname',
    ];
}
