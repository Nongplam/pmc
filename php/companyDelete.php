<?php
/**
 * Created by PhpStorm.
 * User: MRoSlot
 * Date: 3/22/2018
 * Time: 11:43 PM
 */
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

if($data){
    $cid=mysqli_real_escape_string($con,$data->cid);
    $stm1="DELETE FROM company WHERE cid = '$cid'";
    if(mysqli_query($con,$stm1)){
        echo "Data Deleted";
    }else{
        echo "Error";
    }
}