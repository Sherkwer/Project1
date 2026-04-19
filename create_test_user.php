<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create test user for login
$user = \App\Models\User::create([
    'first_name' => 'Admin',
    'middle_name' => 'Test',
    'last_name' => 'User',
    'gender' => 'Male',
    'age' => 30,
    'address' => 'Test Admin',
    'role' => 'Administrator',
    'email' => 'admin@test.com',
    'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
    'email_verified_at' => now()
]);

echo "✓ Test user created for login!\n";
echo "  Email: admin@test.com\n";
echo "  Password: admin123\n";
echo "  Role: Administrator\n";
echo "  ID: " . $user->id . "\n";
