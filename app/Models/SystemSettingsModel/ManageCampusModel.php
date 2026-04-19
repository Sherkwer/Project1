<?php

namespace App\Models\SystemSettingsModel;

use Illuminate\Database\Eloquent\Model;

class ManageCampusModel extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'area_code',
        'area_address',
        'area_report_header_path',
        'receipt_template',
        'receipt_print_option',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
