<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/7/2018
 * Time: 6:46 PM
 */
header('Content-Type: text/html; charset=utf-8');

$data=json_decode(file_get_contents("php://input"));


$enc  = $data->enc;




echo "{\"enc\": \"".md5($enc)."\" }"

?>