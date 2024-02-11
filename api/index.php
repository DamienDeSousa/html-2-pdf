<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!array_key_exists('html', $data)) {
    echo 'No html provided';
    exit;
}

$html = $data['html'];

$dompdf = new Dompdf();
$dompdf->loadHtml($websiteContent);

// (Optional) Setup the paper size and orientation, 'landscape' or 'portrait'
$dompdf->setPaper('A4');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream();
