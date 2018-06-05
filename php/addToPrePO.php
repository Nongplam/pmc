<?php


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];
if($data) {
    $productid =  mysqli_real_escape_string($con,$data ->po_productid);
    $type =   mysqli_real_escape_string($con,$data ->po_type );
    $remain =  mysqli_real_escape_string($con,$data -> po_remain);
    $pricePtype =  mysqli_real_escape_string($con,$data -> po_pricePerType);
    $po_notePro =  mysqli_real_escape_string($con,$data -> po_notePro);
    $pricetotal = $remain*$pricePtype;

    $sqlIn = "INSERT INTO prePo( productid, remain, type, pricePerType,note ,priceall, subbranchid, userid) VALUES ($productid,$remain,'$type',$pricePtype,'$po_notePro',$pricetotal,$subid,$userid)";
    if(mysqli_query($con,$sqlIn)){


    }else{
        echo $sqlIn."\n";
       echo mysqli_error($con);
    }
}

