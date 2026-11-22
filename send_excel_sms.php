
<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/textbee_config.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = __DIR__ . "/uploads/student_data.xlsx";

if (!file_exists($file)) {
    die("Excel file nahi mili.");
}

$sheet = IOFactory::load($file)->getActiveSheet();
$rows = $sheet->toArray();

$url = "https://api.textbee.dev/api/v1/gateway/devices/"
     . $textbee_device_id . "/send-sms";

$message = "Student Alert Demo: This is a test message for our PHP project.";

foreach (array_slice($rows, 1) as $row) {
    $name = trim((string)($row[0] ?? ""));
    $phone = preg_replace('/\D/', '', (string)($row[1] ?? ""));

    if ($phone === "") {
        continue;
    }

    // India country code add karo, agar missing hai
    if (strlen($phone) === 10) {
        $phone = "91" . $phone;
    }

    // Sirf Indian mobile number format accept karo
    if (!preg_match('/^91[6-9]\d{9}$/', $phone)) {
        echo "Skipped invalid number for "
           . htmlspecialchars($name) . "<br>";
        continue;
    }

    $data = [
        "recipients" => [$phone],
        "message" => $message
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-api-key: " . $textbee_api_key
        ],
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 20
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    echo htmlspecialchars($name ?: "Student")
       . " — HTTP " . $status . "<br>";

    if ($response === false) {
        echo "Request error: "
           . htmlspecialchars(curl_error($ch)) . "<br>";
    } else {
        echo "Response: "
           . htmlspecialchars($response) . "<hr>";
    }

    curl_close($ch);
}
?>
