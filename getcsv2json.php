<?php

function csvToJson($csvUrl) {
    $csvData = [];

    // Menggunakan cURL untuk mengambil data CSV dari URL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $csvUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $csvContent = curl_exec($ch);

    if ($csvContent === false) {
        return json_encode(['error' => 'Failed to fetch CSV data']);
    }

    curl_close($ch);

    $lines = explode(PHP_EOL, $csvContent);

    $jsonArray = [];

    $headers = str_getcsv(array_shift($lines));

    foreach ($lines as $line) {
        $data = str_getcsv($line);
        if ($data !== false) {
            $jsonArrayItem = [];
            foreach ($headers as $i => $header) {
                $jsonArrayItem[$header] = $data[$i];
            }
            $jsonArray[] = $jsonArrayItem;
        }
    }

    return json_encode($jsonArray);
}

$csvUrl = 'https://raw.githubusercontent.com/ruzcmc/alpro2tsd2023/main/datapribadi.csv'; // Perhatikan bahwa URL diganti dengan URL raw file CSV
$jsonData = csvToJson($csvUrl);

// Set the content type to JSON
header('Content-Type: application/json');

// Output the JSON data
echo $jsonData;
?>
