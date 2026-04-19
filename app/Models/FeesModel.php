<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FeesModel extends Model
{
    protected $table = 'tbl_fees';

    protected $fillable = [
        'id',
        'fee_name',
        'fee_type_id',
        'amount',
        'description',
        'status',
        'area_code',
        'college_id',
        'organization_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
