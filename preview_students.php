<?php
require_once __DIR__ . "/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = __DIR__ . "/uploads/student_data.xlsx";

if (!file_exists($file)) {
    die("Excel file nahi mili.");
}

$sheet = IOFactory::load($file)->getActiveSheet();
$rows = $sheet->toArray();

echo "<h2>Student Phone Number Preview</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>Name</th><th>Phone</th></tr>";

foreach (array_slice($rows, 1) as $row) {
    $name = htmlspecialchars((string)($row[0] ?? ""));
    $phone = htmlspecialchars((string)($row[1] ?? ""));

    if ($phone !== "") {
        echo "<tr><td>$name</td><td>$phone</td></tr>";
    }
}

echo "</table>";
?>