<?php
// set_time_limit(0);
ini_set('max_execution_time', '300');

require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo 'No data provided';
    exit;
}

if (!array_key_exists('html', $data)) {
    echo 'No html provided';
    exit;
}

$html = $data['html'];

// verify if the given html is a valid url
$regex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-zA-Z0-9+&@#\/%?=~_|!:,.;]*[-a-zA-Z0-9+&@#\/%=~_|]/";
if (filter_var($html, FILTER_VALIDATE_URL) !== false) {
    $html = file_get_contents($html);
}

$dompdf = new Dompdf(['enable_remote' => true, 'isJavascriptEnabled' => true]);
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation, 'landscape' or 'portrait'
$dompdf->setPaper('A4');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream();
