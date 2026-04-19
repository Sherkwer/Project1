<?php
$pdo = new PDO('mysql:host=localhost;dbname=ifsuontime_srtafms', 'root', '');

echo "========================================\n";
echo "Database QR Code Check\n";
echo "========================================\n\n";

// Check students count
$stmt = $pdo->query('SELECT COUNT(*) as count FROM tbl_students');
$studentsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
echo "Total Students: $studentsCount\n";

// Check QR codes count
$stmt = $pdo->query('SELECT COUNT(*) as count FROM tbl_students_qrcode');
$qrCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
echo "Total QR Codes: $qrCount\n\n";

if ($qrCount > 0) {
    echo "Existing QR Codes:\n";
    $stmt = $pdo->query('SELECT q.student_qrcode, q.student_id, s.fullname FROM tbl_student_qrcode q LEFT JOIN tbl_students s ON q.student_id = s.student_id LIMIT 10');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['student_qrcode']} → {$row['student_id']} ({$row['fullname']})\n";
    }
} else {
    echo "No QR codes found. Creating test data...\n\n";

    if ($studentsCount > 0) {
        $stmt = $pdo->query('SELECT student_id, fullname FROM tbl_students LIMIT 4');
        $index = 1;
        while ($student = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $qrCode = 'QR' . str_pad($index, 3, '0', STR_PAD_LEFT);
            $insert = $pdo->prepare('INSERT INTO tbl_student_qrcode (student_qrcode, student_id) VALUES (?, ?)');
            $insert->execute([$qrCode, $student['student_id']]);
            echo "✓ Created {$qrCode} for {$student['fullname']}\n";
            $index++;
        }
    }
}

echo "\n========================================\n";
echo "Testing Validation Logic\n";
echo "========================================\n\n";

$testQRs = ['QR001', 'INVALID_TEST', 'QR002'];
$validated = [];
$invalid = [];

foreach ($testQRs as $qr) {
    $stmt = $pdo->prepare('SELECT q.student_qrcode, q.student_id, s.fullname FROM tbl_student_qrcode q LEFT JOIN tbl_students s ON q.student_id = s.student_id WHERE q.student_qrcode = ?');
    $stmt->execute([$qr]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $validated[] = [
            'student_qrcode' => $result['student_qrcode'],
            'student_id' => $result['student_id'],
            'fullname' => $result['fullname']
        ];
        echo "✓ VALID: $qr\n";
    } else {
        $invalid[] = $qr;
        echo "✗ INVALID: $qr\n";
    }
}

echo "\nResult:\n";
echo "Valid: " . count($validated) . "\n";
echo "Invalid: " . count($invalid) . "\n";

if (!empty($validated)) {
    echo "\nValidated Students:\n";
    foreach ($validated as $student) {
        echo "  - {$student['student_qrcode']} | {$student['student_id']} | {$student['fullname']}\n";
    }
}

echo "\n========================================\n";
