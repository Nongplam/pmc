<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/8/2018
 * Time: 1:43 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


if($data) {
    $POdetail = mysqli_real_escape_string($con,$data->id);

    $sql = "DELETE FROM rpt_POdetail WHERE rpt_POD_id = $POdetail";
    if(mysqli_query($con,$sql)){
        echo "{\"del\":true}";
    }else{
        echo "{\"del\":false,\"delErroe\":\"".mysqli_error($con)."\"}";
    }



}