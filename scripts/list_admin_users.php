<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\SystemSettingsModel\ManageRolesModel;

$adminRoleId = ManageRolesModel::whereRaw('LOWER(name)=?', [strtolower('Administrator')])->value('id');
$superRoleId = ManageRolesModel::whereRaw('LOWER(name)=?', [strtolower('Super Administrator')])->value('id');

echo "Administrator role id: " . var_export($adminRoleId, true) . "\n";
echo "Super Administrator role id: " . var_export($superRoleId, true) . "\n\n";

$users = User::orderBy('id')->get();
foreach ($users as $u) {
    $roleId = isset($u->user_role) && is_numeric($u->user_role) ? (int) $u->user_role : null;
    $roleName = $u->getRoleName();
    echo "id={$u->id}\temail={$u->email}\tuser_role_raw=" . var_export($u->user_role, true) . "\tis_admin=" . var_export($u->is_admin, true) . "\tresolved_role=" . var_export($roleName, true) . "\n";
}
