<?php

namespace App\Models\SystemSettingsModel;

use Illuminate\Database\Eloquent\Model;

class ManageOrganizationModel extends Model
{
    protected $table = 'tbl_organizations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'description',
        'area_code',
        'college_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
