
<?php
require_once __DIR__ . "/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = __DIR__ . "/uploads/student_data.xlsx";

if (!file_exists($file)) {
    die("Error: Excel file nahi mili.");
}

$spreadsheet = IOFactory::load($file);
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

echo "<h2>Student Excel Data</h2>";
echo "<table border='1' cellpadding='8'>";

foreach ($rows as $row) {
    echo "<tr>";
    foreach ($row as $cell) {
        echo "<td>" . htmlspecialchars((string)($cell ?? "")) . "</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>
