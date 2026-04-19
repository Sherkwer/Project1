<?php

// Load Laravel application
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a fake request
use Illuminate\Http\Request;
use App\Models\studentQRCode_Model;
use App\Models\studentsManagement_Model;
use App\Http\Controllers\attendanceManagement_Controller;

echo "========================================\n";
echo "QR CODE VALIDATION FUNCTIONALITY TEST\n";
echo "========================================\n\n";

// Step 1: Check existing QR codes in database
echo "[STEP 1] Checking existing QR codes in database...\n";
$existingQrcodes = studentQRCode_Model::with('student')->limit(10)->get();

if ($existingQrcodes->isEmpty()) {
    echo "⚠️  No QR codes found in database.\n";
    echo "Creating test QR codes...\n\n";

    // Check for existing students
    $students = studentsManagement_Model::limit(4)->get();

    if ($students->isEmpty()) {
        echo "❌ ERROR: No students found in database. Please add students first.\n";
        exit;
    }

    foreach ($students as $index => $student) {
        $qrCode = 'QR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
        $newQR = studentQRCode_Model::create([
            'student_qrcode' => $qrCode,
            'student_id' => $student->student_id
        ]);
        echo "✓ Created QR Code: {$qrCode} -> {$student->fullname}\n";
    }
    $existingQrcodes = studentQRCode_Model::with('student')->limit(10)->get();
} else {
    echo "✓ Found " . count($existingQrcodes) . " QR codes:\n";
    foreach ($existingQrcodes as $qr) {
        $name = ($qr->student) ? $qr->student->fullname : 'Unknown Student';
        echo "  - {$qr->student_qrcode} → {$qr->student_id} ({$name})\n";
    }
}

echo "\n";

// Step 2: Test the validate_import function
echo "[STEP 2] Testing validate_import function...\n";

$testQRCodes = [
    $existingQrcodes->first()->student_qrcode, // Valid QR
    'INVALID_QR_TEST_123',                      // Invalid QR
    $existingQrcodes->skip(1)->first()->student_qrcode ?? $existingQrcodes->first()->student_qrcode // Another valid QR
];

echo "Test QR Codes: " . json_encode($testQRCodes) . "\n\n";

// Create a mock request
$request = new Request();
$request->merge(['qrcodes' => $testQRCodes]);

// Instantiate controller
$controller = new attendanceManagement_Controller();

// Call the validate_import function
$response = $controller->validate_import($request);

// Get the JSON response
$jsonResponse = json_decode($response->getContent(), true);

echo "Response from validate_import:\n";
echo json_encode($jsonResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";

// Step 3: Detailed validation report
echo "[STEP 3] Validation Report:\n";
echo "Total QR Codes Tested: " . count($testQRCodes) . "\n";
echo "Valid Records Found: " . $jsonResponse['validatedCount'] . "\n";
echo "Invalid QR Codes: " . $jsonResponse['invalidCount'] . "\n\n";

if (!empty($jsonResponse['validatedStudents'])) {
    echo "✓ VALIDATED STUDENTS:\n";
    foreach ($jsonResponse['validatedStudents'] as $student) {
        echo "  - QR: {$student['student_qrcode']} | ID: {$student['student_id']} | Name: {$student['fullname']}\n";
    }
} else {
    echo "⚠️  No valid students found.\n";
}

if (!empty($jsonResponse['invalidQrcodes'])) {
    echo "\n❌ INVALID QR CODES:\n";
    foreach ($jsonResponse['invalidQrcodes'] as $invalid) {
        echo "  - {$invalid}\n";
    }
}

echo "\n========================================\n";
echo "TEST COMPLETED\n";
echo "========================================\n";
