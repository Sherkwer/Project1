<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
// Try reading protected property routeMiddleware via reflection
$ref = new \ReflectionClass($httpKernel);
$props = [];
if ($ref->hasProperty('routeMiddleware')) {
    $p = $ref->getProperty('routeMiddleware');
    $p->setAccessible(true);
    $props = $p->getValue($httpKernel);
}

echo "Route middleware aliases:\n";
print_r($props);
