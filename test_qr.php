<?php

use App\Models\studentQRCode_Model;
use App\Models\studentsManagement_Model;

echo "========================================\n";
echo "QR CODE VALIDATION TEST\n";
echo "========================================\n\n";

// Check existing QR codes
$qrcodes = studentQRCode_Model::with('student')->get();

echo "[1] Database QR Codes:\n";
if ($qrcodes->isEmpty()) {
    echo "No QR codes found. Creating test data...\n";
    $students = studentsManagement_Model::limit(4)->get();

    if ($students->isEmpty()) {
        echo "No students found. Create students first.\n";
        return;
    }

    foreach ($students as $index => $student) {
        $qr = 'QR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
        studentQRCode_Model::create(['student_qrcode' => $qr, 'student_id' => $student->student_id]);
        echo "✓ Created {$qr} for {$student->fullname}\n";
    }
} else {
    foreach ($qrcodes as $qr) {
        $name = $qr->student ? $qr->student->fullname : 'N/A';
        echo "✓ {$qr->student_qrcode} → {$name}\n";
    }
}

echo "\n[2] Testing Validation Logic:\n";

// Test QR codes
$testQRs = ['QR001', 'INVALID_QR', 'QR002'];
$validated = [];
$invalid = [];

foreach ($testQRs as $qr) {
    $found = studentQRCode_Model::where('student_qrcode', $qr)->with('student')->first();
    if ($found && $found->student) {
        $validated[] = [
            'student_qrcode' => $found->student_qrcode,
            'student_id' => $found->student_id,
            'fullname' => $found->student->fullname
        ];
        echo "✓ VALID: {$qr}\n";
    } else {
        $invalid[] = $qr;
        echo "✗ INVALID: {$qr}\n";
    }
}

echo "\n[3] Result Summary:\n";
echo "Valid Records: " . count($validated) . "\n";
echo "Invalid Records: " . count($invalid) . "\n";

if (!empty($validated)) {
    echo "\nValidated Students:\n";
    foreach ($validated as $student) {
        echo "  - {$student['student_qrcode']} | {$student['student_id']} | {$student['fullname']}\n";
    }
}
