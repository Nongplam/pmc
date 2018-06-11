<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 7:34 PM
 */


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$rpo_id = mysqli_real_escape_string($con ,$data-> rpo_id);
$preStock_id = mysqli_real_escape_string($con ,$data-> preStock_id);
$lotno =  mysqli_real_escape_string($con ,$data-> lotno);
$expireday= mysqli_real_escape_string($con ,$data-> expireday);
$barcode =  mysqli_real_escape_string($con ,$data-> barcode);


$updatePreStock = "UPDATE preToStock SET preToStock.lotno = '$lotno',preToStock.expireday = '$expireday',preToStock.barcode = '$barcode' ,preToStock.status_detail = 0 WHERE preToStock.preToStock_id = $preStock_id ";
if(mysqli_query($con,$updatePreStock)){
    echo "{\"Insert\" : true}";
}