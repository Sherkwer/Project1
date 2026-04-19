<?php

namespace App\Models\SystemSettingsModel;

use Illuminate\Database\Eloquent\Model;

class ManageRolesModel extends Model
{
    protected $table = 'tbl_roles';
    protected $fillable = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
