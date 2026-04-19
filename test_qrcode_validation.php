<?php

// Test QR Code Validation
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';

use App\Models\studentQRCode_Model;
use App\Models\studentsManagement_Model;

// Query all QR codes
echo "=== Checking Existing QR Codes ===\n\n";

$qrcodes = studentQRCode_Model::with('student')->get();

if ($qrcodes->isEmpty()) {
    echo "No QR codes found in database. Creating test data...\n\n";

    // First, check if there are any students
    $students = studentsManagement_Model::limit(3)->get();

    if ($students->isEmpty()) {
        echo "No students found. Please add students first.\n";
        exit;
    }

    // Create test QR codes for existing students
    foreach ($students as $index => $student) {
        $testQRCode = 'QR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

        $qrCode = new studentQRCode_Model();
        $qrCode->student_qrcode = $testQRCode;
        $qrCode->student_id = $student->student_id;
        $qrCode->save();

        echo "Created QR Code: {$testQRCode} -> Student ID: {$student->student_id} ({$student->fullname})\n";
    }
} else {
    echo "Found " . count($qrcodes) . " QR codes:\n";
    foreach ($qrcodes as $qr) {
        $name = ($qr->student && $qr->student->fullname) ? $qr->student->fullname : 'N/A';
        echo "QR Code: {$qr->student_qrcode} | Student ID: {$qr->student_id} | Name: {$name}\n";
    }
}

echo "\n=== Testing Validation Function ===\n\n";

// Get a QR code to test with
$testQR = studentQRCode_Model::first();

if ($testQR) {
    echo "Testing with QR Code: {$testQR->student_qrcode}\n";

    // Simulate the validation
    $found = studentQRCode_Model::where('student_qrcode', $testQR->student_qrcode)
        ->with('student')
        ->first();

    if ($found && $found->student) {
        echo "✓ VALID: Found in database\n";
        echo "  - QR Code: {$found->student_qrcode}\n";
        echo "  - Student ID: {$found->student_id}\n";
        echo "  - Full Name: {$found->student->fullname}\n";
    } else {
        echo "✗ INVALID: Not found in database\n";
    }
} else {
    echo "No QR codes available for testing.\n";
}

echo "\n";
