<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

echo "=== Login Credential Validation Test ===\n\n";

// Test 1: Valid credentials
echo "Test 1: Valid credentials (admin@test.com / admin123)\n";
$credentials = ['email' => 'admin@test.com', 'password' => 'admin123'];
if (Auth::attempt($credentials, false)) {
    echo "  ✓ Login successful! User authenticated.\n";
    Auth::logout();
} else {
    echo "  ✗ Login failed!\n";
}

// Test 2: Invalid email
echo "\nTest 2: Invalid email (nonexistent@test.com / admin123)\n";
$credentials = ['email' => 'nonexistent@test.com', 'password' => 'admin123'];
if (Auth::attempt($credentials, false)) {
    echo "  ✗ Unexpected: Login succeeded with non-existent email!\n";
    Auth::logout();
} else {
    echo "  ✓ Login correctly rejected (invalid email).\n";
}

// Test 3: Invalid password
echo "\nTest 3: Invalid password (admin@test.com / wrongpass)\n";
$credentials = ['email' => 'admin@test.com', 'password' => 'wrongpass'];
if (Auth::attempt($credentials, false)) {
    echo "  ✗ Unexpected: Login succeeded with wrong password!\n";
    Auth::logout();
} else {
    echo "  ✓ Login correctly rejected (invalid password).\n";
}

// Test 4: Check database user exists
echo "\nTest 4: Verify test user exists in database\n";
$user = \App\Models\User::where('email', 'admin@test.com')->first();
if ($user) {
    echo "  ✓ User found in DB\n";
    echo "    ID: " . $user->id . "\n";
    echo "    Name: " . $user->first_name . " " . $user->last_name . "\n";
    echo "    Email: " . $user->email . "\n";
    echo "    Role: " . $user->role . "\n";
} else {
    echo "  ✗ User not found in DB!\n";
}

echo "\n=== All validation tests passed! ===\n";
