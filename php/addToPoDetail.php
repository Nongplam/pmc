<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/7/2018
 * Time: 8:55 PM
 */




session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];
if($data) {
    $no = mysqli_real_escape_string($con,$data->no);
    $po_no =  sprintf("%'.010d", $no);
    $productid =  mysqli_real_escape_string($con,$data ->po_productid);
    $type =   mysqli_real_escape_string($con,$data ->po_type );
    $remain =  mysqli_real_escape_string($con,$data -> po_remain);
    $pricePtype =  mysqli_real_escape_string($con,$data -> po_pricePerType);
    $po_notePro =  mysqli_real_escape_string($con,$data -> po_notePro);
    $pricetotal = $remain*$pricePtype;

    $sqlIn = "INSERT INTO rpt_POdetail( rptPO_no,productid, remain, type, pricePerType,note ,priceall, subbranchid, userid) VALUES ('$po_no',$productid,$remain,'$type',$pricePtype,'$po_notePro',$pricetotal,$subid,$userid)";
    if(mysqli_query($con,$sqlIn)){

        echo "{\"add\":true}";
    }else{
        echo "{\"add\":false,\"addErroe\":\"".mysqli_error($con)."\"}";
    }
}

