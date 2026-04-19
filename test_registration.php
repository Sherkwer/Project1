<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create test user
$user = \App\Models\User::create([
    'first_name' => 'Jane',
    'middle_name' => 'M',
    'last_name' => 'Smith',
    'gender' => 'Female',
    'age' => 28,
    'address' => '456 Test Ave',
    'role' => 'Administrator',
    'email' => 'jane@example.com',
    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
    'email_verified_at' => now()
]);

echo "✓ User created! ID: " . $user->id . "\n";

// Verify by querying back
$verify = \App\Models\User::where('email', 'jane@example.com')->first();
echo "✓ Verified in DB:\n";
echo json_encode($verify->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
