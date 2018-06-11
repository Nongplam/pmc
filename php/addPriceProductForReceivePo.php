<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 8:03 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$rpo_id = mysqli_real_escape_string($con ,$data-> rpo_id);
$preStock_id = mysqli_real_escape_string($con ,$data-> preStock_id);
$baseprice = mysqli_real_escape_string($con,$data->baseprice);
$boxprice = mysqli_real_escape_string($con,$data->boxprice);
$retailprice = mysqli_real_escape_string($con,$data->retailprice);
$wholesaleprice = mysqli_real_escape_string($con,$data->wholesaleprice);


$updatePreStock = "UPDATE preToStock SET preToStock.baseprice = $baseprice ,preToStock.boxprice = $boxprice ,preToStock.retailprice = $retailprice,preToStock.wholesaleprice = $wholesaleprice  ,preToStock.status_price = 0 WHERE preToStock.preToStock_id = $preStock_id ";
if(mysqli_query($con,$updatePreStock)){
    echo "{\"Insert\" : true}";
}