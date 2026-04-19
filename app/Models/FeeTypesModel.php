<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeTypesModel extends Model
{
    protected $table = 'tbl_fee_types';
    protected $fillable = [
        'id',
        'name',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
