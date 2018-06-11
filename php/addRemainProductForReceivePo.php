<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 3:35 PM
 */


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$rpo_id = mysqli_real_escape_string($con ,$data-> rpo_id);
$preStock_id = mysqli_real_escape_string($con ,$data-> preStock_id);
$qty = mysqli_real_escape_string($con,$data -> qty);
$date = mysqli_real_escape_string($con,$data -> receivedate);

$updateReceivePO = "UPDATE rpt_recivePOdetail SET rpt_recivePOdetail.rptRecivePOdetailI_Qty = $qty WHERE rpt_recivePOdetail.rptRecivePOdetailI_Id = $rpo_id";

if(mysqli_query($con,$updateReceivePO)){
    $updatePreStock = "UPDATE preToStock SET preToStock.remainfull = $qty,preToStock.receiveday = '$date' ,preToStock.status_remain = 0 WHERE preToStock.preToStock_id = $preStock_id ";
    if(mysqli_query($con,$updatePreStock)){
        echo "{\"Insert\" : true}";
    }
}




