<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\SystemSettingsModel\ManageRolesModel;

$user = User::find(2);
$roles = 'superadmin,admin,officer';

echo "Simulating for user id={$user->id}, email={$user->email}\n";

$aliases = config('roles.aliases', []);
$allowedRaw = array_filter(array_map('trim', preg_split('/[|,]/', $roles ?? '')));
$allowedIds = [];
$allowedNames = [];
foreach ($allowedRaw as $roleItem) {
    if ($roleItem === '') continue;
    if (ctype_digit((string)$roleItem)) { $allowedIds[] = (int)$roleItem; continue; }
    $key = strtolower(preg_replace('/[^a-z0-9]/', '', $roleItem));
    if (isset($aliases[$key])) { $allowedNames[] = $aliases[$key]; continue; }
    $roleModel = ManageRolesModel::whereRaw('LOWER(name) = ?', [strtolower($roleItem)])->first();
    if ($roleModel) { $allowedNames[] = $roleModel->name; continue; }
    $allowedNames[] = $roleItem;
}
$allowedIds = array_unique($allowedIds);
$allowedNames = array_unique($allowedNames);

echo "allowedNames: "; print_r($allowedNames);
echo "allowedIds: "; print_r($allowedIds);

// Resolve user's role id
$userRoleId = null;
if (isset($user->user_role) && is_numeric($user->user_role)) {
    $userRoleId = (int)$user->user_role;
} elseif (isset($user->role) && $user->role) {
    $userRoleId = $user->role->id ?? null;
}

echo "userRoleId: "; var_export($userRoleId); echo "\n";

$userRoleName = method_exists($user, 'getRoleName') ? $user->getRoleName() : ($user->user_role ?? null);
echo "userRoleName: "; var_export($userRoleName); echo "\n";

// id check
if (!empty($allowedIds) && $userRoleId !== null) {
    if (in_array($userRoleId, $allowedIds, true)) {
        echo "Allowed by id match\n";
    }
}

// name checks
foreach ($allowedNames as $allowedName) {
    if (is_string($allowedName) && $userRoleName && strcasecmp($allowedName, $userRoleName) === 0) {
        echo "Allowed by name match: $allowedName\n";
    }
}

// is_admin check
if (!empty($user->is_admin) && (int)$user->is_admin === 1) {
    if (is_string($roles) && preg_match('/\b(admin|administrator)\b/i', $roles)) {
        echo "is_admin bypass applies\n";
    }
}

echo "done\n";
