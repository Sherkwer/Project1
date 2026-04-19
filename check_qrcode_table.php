<?php
$pdo = new PDO('mysql:host=localhost;dbname=ifsuontime_srtafms', 'root', '');

echo "========================================\n";
echo "Checking tbl_students_qrcode Table\n";
echo "========================================\n\n";

// Check table structure
$stmt = $pdo->query('DESCRIBE tbl_students_qrcode');
echo "Table Structure:\n";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
}

echo "\n";

// Check sample records
$stmt = $pdo->query('SELECT * FROM tbl_students_qrcode LIMIT 5');
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total Records: " . count($records) . "\n";
if (!empty($records)) {
    echo "\nSample Records:\n";
    foreach ($records as $index => $record) {
        echo "Record " . ($index + 1) . ":\n";
        foreach ($record as $key => $value) {
            echo "  $key: $value\n";
        }
        echo "\n";
    }
}

echo "========================================\n";
