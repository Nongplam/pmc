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

$mpdf->writeBarcode('978-1234-567-890');
$mpdf->Output();