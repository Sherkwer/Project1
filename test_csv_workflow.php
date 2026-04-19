<?php

echo "========================================\n";
echo "COMPLETE CSV IMPORT WORKFLOW TEST\n";
echo "========================================\n\n";

// Read CSV file
$csvFile = 'sample_attendance_import.csv';
echo "[STEP 1] Reading CSV File: $csvFile\n";

if (!file_exists($csvFile)) {
    echo "❌ File not found!\n";
    exit;
}

$csvData = file_get_contents($csvFile);
$rows = array_filter(array_map('trim', explode("\n", $csvData)), fn($row) => $row !== '');

echo "✓ File loaded successfully\n";
echo "✓ Total rows (including header): " . count($rows) . "\n";
echo "✓ Data rows: " . (count($rows) - 1) . "\n\n";

// Parse CSV
echo "[STEP 2] Parsing CSV Data\n";
$headers = str_getcsv($rows[0]);
echo "Headers: " . implode(", ", $headers) . "\n\n";

$qrcodes = [];
$csvRecords = [];

for ($i = 1; $i < count($rows); $i++) {
    $data = str_getcsv($rows[$i]);
    $record = array_combine($headers, $data);
    $csvRecords[] = $record;
    $qrcodes[] = $record['student_qrcode'];
    echo "Row $i: {$record['student_qrcode']} | {$record['student_id']} | {$record['attendance_date']}\n";
}

echo "\n";

// Extract unique QR codes for validation
$uniqueQRCodes = array_unique($qrcodes);
echo "[STEP 3] Extracting Unique QR Codes for Validation\n";
echo "Total QR codes in CSV: " . count($qrcodes) . "\n";
echo "Unique QR codes: " . count($uniqueQRCodes) . "\n\n";

foreach ($uniqueQRCodes as $qr) {
    echo "  - $qr\n";
}

echo "\n";

// Validate against database
echo "[STEP 4] Validating QR Codes Against Database\n";

$pdo = new PDO('mysql:host=localhost;dbname=ifsuontime_srtafms', 'root', '');
$validatedStudents = [];
$invalidQrcodes = [];

foreach ($uniqueQRCodes as $qrcode) {
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

// Step 5: Display results
echo "[STEP 5] Validation Summary\n";
echo "Total Unique QR Codes: " . count($uniqueQRCodes) . "\n";
echo "Valid QR Codes: " . count($validatedStudents) . "\n";
echo "Invalid QR Codes: " . count($invalidQrcodes) . "\n\n";

echo "✓ VALIDATED STUDENTS:\n";
foreach ($validatedStudents as $index => $student) {
    echo "  " . ($index + 1) . ". {$student['student_qrcode']} → {$student['student_id']} ({$student['fullname']})\n";
}

if (!empty($invalidQrcodes)) {
    echo "\n❌ INVALID QR CODES:\n";
    foreach ($invalidQrcodes as $qr) {
        echo "  - $qr\n";
    }
}

echo "\n";

// Step 6: Filter records by valid QR codes
echo "[STEP 6] Filtering Attendance Records by Valid QR Codes\n";
$validQRSet = array_column($validatedStudents, 'student_qrcode');
$validRecords = array_filter($csvRecords, fn($record) => in_array($record['student_qrcode'], $validQRSet));

echo "Records to import: " . count($validRecords) . "\n";
foreach ($validRecords as $record) {
    echo "  - {$record['student_qrcode']} | {$record['student_id']} | {$record['attendance_date']}\n";
}

echo "\n";

// Step 7: API Response
echo "[STEP 7] API Response (JSON)\n";
$apiResponse = [
    'success' => true,
    'validatedCount' => count($validatedStudents),
    'invalidCount' => count($invalidQrcodes),
    'validatedStudents' => $validatedStudents,
    'invalidQrcodes' => $invalidQrcodes,
    'validRecordsToImport' => count($validRecords)
];

echo json_encode($apiResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

echo "\n\n========================================\n";
echo "✓ WORKFLOW TEST COMPLETED SUCCESSFULLY\n";
echo "========================================\n";
