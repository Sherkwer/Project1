<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$columns = DB::select("DESCRIBE db_colleges");
foreach ($columns as $column) {
    echo $column->Field . ": " . ($column->Default ?? 'NULL') . "\n";
}
