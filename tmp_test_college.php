<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$x = App\Models\SystemSettingsModel\ManageCollegeModel::where('area_code', 'TEST')->first();
var_dump($x ? $x->toArray() : null);
