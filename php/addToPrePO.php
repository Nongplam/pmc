<?php


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = 31/* $_SESSION['id']*/;
$subid = 1/*$_SESSION['subbranchid']*/;
if($data) {
    $productid =  mysqli_real_escape_string($con,$data ->po_productid);
    $type =   mysqli_real_escape_string($con,$data ->po_type );
    $remain =  mysqli_real_escape_string($con,$data -> po_remain);
    $pricePtype =  mysqli_real_escape_string($con,$data -> po_pricePerType);
    $po_discount =  mysqli_real_escape_string($con,$data -> po_discount);
    $pricetotal = $remain*$pricePtype;
    $pricedis = ($pricetotal*$po_discount)/100;

    $priceall = ($pricetotal)-$pricedis;
    $sqlIn = "INSERT INTO prePo( productid, remain, type, pricePerType,discount ,priceall, subbranchid, userid) VALUES ($productid,$remain,'$type',$pricePtype,$po_discount,$priceall,$subid,$userid)";
    if(mysqli_query($con,$sqlIn)){


    }else{
        echo $sqlIn."\n";
       echo mysqli_error($con);
    }
}

