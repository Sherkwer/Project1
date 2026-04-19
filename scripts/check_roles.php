<?php
// Temporary diagnostic script - prints user role and roles table
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\SystemSettingsModel\ManageRolesModel;

$id = 1; // administrator id to inspect
$user = User::find($id);
if (! $user) {
    echo "User with id={$id} not found\n";
    exit(1);
}

echo "USER:\n";
echo "id: " . $user->id . "\n";
echo "email: " . ($user->email ?? 'N/A') . "\n";
echo "raw user_role: " . var_export($user->user_role, true) . "\n";
echo "is_admin: " . var_export($user->is_admin, true) . "\n";
echo "getRoleName(): " . var_export($user->getRoleName(), true) . "\n";

echo "\nROLES TABLE:\n";
$roles = ManageRolesModel::orderBy('id')->get();
foreach ($roles as $r) {
    echo "id={$r->id}\tname={$r->name}\n";
}

echo "\nEND\n";
