<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 6:11 PM
 */


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$date =  mysqli_real_escape_string($con,$data->date);
$no = mysqli_real_escape_string($con,$data->po_no);
$po_no =  sprintf("%'.010d", $no);

$updateReceivePO = "UPDATE rpt_recivePO SET rpt_recivePO.recieive_Date = '$date' WHERE rpt_recivePO.rptPO_no = '$po_no' AND rpt_recivePO.subbranchid = $subid";

if(mysqli_query($con,$updateReceivePO)){
    echo "{\"Insert\" : true}";
}else{
    echo  mysqli_error($con);
}