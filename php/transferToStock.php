<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 9:07 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


$no = mysqli_real_escape_string($con,$data->po_no);
$po_no =  sprintf("%'.010d", $no);

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];




$sql = "INSERT INTO stock(barcode, PO_No, productid, cid, remainfull, remain, lotno, stocktype, costprice, baseprice, boxprice, retailprice, wholesaleprice, receiveday, expireday, subbranchid, userid, logdatetime ) 
                  SELECT  barcode, PO_No, productid, cid, remainfull,remainfull, lotno, stocktype, costprice, baseprice, boxprice, retailprice, wholesaleprice, receiveday, expireday ,subbranchid,$userid,NOW()  FROM preToStock WHERE remainfull <> 0 AND PO_No = '$po_no' AND subbranchid = $subid";



if(mysqli_query($con,$sql)){


    $sqlDelete = "DELETE FROM preToStock WHERE PO_No = '$po_no' AND  subbranchid = $subid";
    if(mysqli_query($con,$sqlDelete)){
        echo "{\"Insert\" : true}";
    }else{
        echo  mysqli_error($con);
    }
}else{
    echo  mysqli_error($con);
}