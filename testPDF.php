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
    'mode' => 'c',
    'format' => [190, 236],
    'autoLangToFont' => true
]);

$mpdf->pdf_version = '7.0.3';

$mpdf->writeHTML('<barcode code="024681024680" type="EAN128C" /><br />');
$mpdf->Output();