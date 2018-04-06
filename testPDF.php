<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 3/30/2018
 * Time: 5:24 PM
 */


require_once __DIR__ . '/vendor/autoload.php';
// Create an instance of the class:




$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => [190, 236],
    'autoLangToFont' => true
]);

$mpdf->pdf_version = '7.0.3';

// Write some HTML code:
$mpdf->WriteHTML("<p lang='th'>สวัสดีชาว World</p>");

$mpdf->AddPage(); // Adds a new page in Landscape orientation
$mpdf->WriteHTML('สวัสดีชาว World');


// Output a PDF file directly to the browser
$mpdf->Output();