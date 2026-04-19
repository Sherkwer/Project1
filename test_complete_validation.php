<?php
$pdo = new PDO('mysql:host=localhost;dbname=ifsuontime_srtafms', 'root', '');

echo "========================================\n";
echo "QR CODE VALIDATION FUNCTIONALITY TEST\n";
echo "========================================\n\n";

// Step 1: Show all existing QR codes
echo "[STEP 1] Existing QR Codes in Database\n";
$stmt = $pdo->query('SELECT student_qrcode, student_id, fullname FROM tbl_students_qrcode');
$existingQRs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($existingQRs)) {
    echo "No QR codes found. Creating test data...\n\n";

    // Get some students
    $stmt = $pdo->query('SELECT student_id FROM tbl_students LIMIT 3');
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($students as $index => $student) {
        $qrCode = 'QR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
        $insert = $pdo->prepare('INSERT INTO tbl_students_qrcode (student_qrcode, student_id, fullname) VALUES (?, ?, ?)');
        $insert->execute([$qrCode, $student['student_id'], 'Test Student ' . ($index + 1)]);
        echo "✓ Created: $qrCode -> {$student['student_id']}\n";
    }

    // Refresh list
    $stmt = $pdo->query('SELECT student_qrcode, student_id, fullname FROM tbl_students_qrcode');
    $existingQRs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Found " . count($existingQRs) . " QR codes:\n";
    foreach ($existingQRs as $qr) {
        echo "✓ {$qr['student_qrcode']} → {$qr['student_id']} ({$qr['fullname']})\n";
    }
}

echo "\n";

// Step 2: Test validation logic (simulating what the controller does)
echo "[STEP 2] Testing Validation Logic\n";

$testQRCodes = [
    $existingQRs[0]['student_qrcode'],  // Valid
    'INVALID_QR_TEST_123',              // Invalid
    isset($existingQRs[1]) ? $existingQRs[1]['student_qrcode'] : $existingQRs[0]['student_qrcode'],  // Valid
];

echo "Test QR Codes:\n";
foreach ($testQRCodes as $qr) {
    echo "  - $qr\n";
}
echo "\n";

$validatedStudents = [];
$invalidQrcodes = [];

foreach ($testQRCodes as $qrcode) {
    $stmt = $pdo->prepare('SELECT student_qrcode, student_id, fullname FROM tbl_students_qrcode WHERE student_qrcode = ?');
    $stmt->execute([trim($qrcode)]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $validatedStudents[] = [
            'student_qrcode' => $student['student_qrcode'],
            'student_id' => $student['student_id'],
            'fullname' => $student['fullname']
        ];
        echo "✓ VALID: {$qrcode}\n";
    } else {
        $invalidQrcodes[] = $qrcode;
        echo "✗ INVALID: {$qrcode}\n";
    }
}

echo "\n";

// Step 3: Display results
echo "[STEP 3] Validation Results\n";
echo "Total QR Codes Tested: " . count($testQRCodes) . "\n";
echo "Valid Records Found: " . count($validatedStudents) . "\n";
echo "Invalid QR Codes: " . count($invalidQrcodes) . "\n\n";

if (!empty($validatedStudents)) {
    echo "✓ VALIDATED STUDENTS:\n";
    foreach ($validatedStudents as $student) {
        echo "  - QR: {$student['student_qrcode']} | ID: {$student['student_id']} | Name: {$student['fullname']}\n";
    }
}

if (!empty($invalidQrcodes)) {
    echo "\n❌ INVALID QR CODES:\n";
    foreach ($invalidQrcodes as $invalid) {
        echo "  - {$invalid}\n";
    }
}

echo "\n";

// Step 4: JSON Response (what the API returns)
echo "[STEP 4] JSON Response (API Format)\n";
$apiResponse = [
    'success' => true,
    'validatedCount' => count($validatedStudents),
    'invalidCount' => count($invalidQrcodes),
    'validatedStudents' => $validatedStudents,
    'invalidQrcodes' => $invalidQrcodes
];

echo json_encode($apiResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

echo "\n\n========================================\n";
echo "TEST COMPLETED SUCCESSFULLY\n";
echo "========================================\n";
