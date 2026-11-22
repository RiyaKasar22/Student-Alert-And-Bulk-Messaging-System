```php
<?php
$file = __DIR__ . "/students_bulk.csv";

if (!file_exists($file)) {
    die("CSV file not found!");
}

$handle = fopen($file, "r");

if ($handle === false) {
    die("Unable to open CSV file!");
}

echo "<h2>Student Data from Excel</h2>";

echo "<table border='1' cellpadding='10'>";
echo "<tr>
        <th>Name</th>
        <th>Phone</th>
      </tr>";

$header = fgetcsv($handle);

while (($row = fgetcsv($handle)) !== false) {

    if (count($row) >= 2 && !empty(trim($row[0])) && !empty(trim($row[1]))) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row[0]) . "</td>";
        echo "<td>" . htmlspecialchars($row[1]) . "</td>";
        echo "</tr>";
    }
}

echo "</table>";

fclose($handle);
?>
```
