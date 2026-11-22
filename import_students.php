
<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/db.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = __DIR__ . "/uploads/student_data.xlsx";

if (!file_exists($file)) {
    die("Excel file nahi mili.");
}

$sheet = IOFactory::load($file)->getActiveSheet();
$rows = $sheet->toArray();

$added = 0;
$skipped = 0;

foreach (array_slice($rows, 1) as $row) {
    $name = trim((string)($row[0] ?? ""));
    $phone = trim((string)($row[1] ?? ""));

    if ($name === "" || $phone === "") {
        $skipped++;
        continue;
    }

    // Skip if this phone number already exists
    $check = mysqli_prepare(
        $conn,
        "SELECT id FROM students WHERE mobile = ? LIMIT 1"
    );
    mysqli_stmt_bind_param($check, "s", $phone);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) > 0) {
        $skipped++;
        mysqli_stmt_close($check);
        continue;
    }
    mysqli_stmt_close($check);

    $roll_no = "EXCEL_" . preg_replace('/\D/', '', $phone);
    $class = "Not Assigned";
    $status = "Active";

    $insert = mysqli_prepare(
        $conn,
        "INSERT INTO students (name, roll_no, mobile, class, status)
         VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $insert,
        "sssss",
        $name,
        $roll_no,
        $phone,
        $class,
        $status
    );

    if (mysqli_stmt_execute($insert)) {
        $added++;
    } else {
        echo "Error adding " . htmlspecialchars($name) . ": "
            . htmlspecialchars(mysqli_stmt_error($insert)) . "<br>";
    }

    mysqli_stmt_close($insert);
}

echo "<h2>Excel Import Finished</h2>";
echo "<p>Added: $added students</p>";
echo "<p>Skipped (blank or already existing phone): $skipped</p>";
echo '<p><a href="/std/login.html">Open Dashboard</a></p>';
?>
