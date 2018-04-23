<?php
/**
 * Created by PhpStorm.
 * User: Abadon
*/

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$poNO = mysqli_real_escape_string($con, $data->poNo);
$rpt_POD_id  = mysqli_real_escape_string($con, $data->rpt_POD_id);
$productid=mysqli_real_escape_string($con, $data->productid);
$cid=mysqli_real_escape_string($con, $data->cid);
$remain=mysqli_real_escape_string($con, $data->remain);
$lotno=mysqli_real_escape_string($con, $data->lotno);
$stocktype = mysqli_real_escape_string($con, $data->stocktype);
$costprice=mysqli_real_escape_string($con, $data->costprice);
$baseprice=mysqli_real_escape_string($con, $data->baseprice);
$boxprice=mysqli_real_escape_string($con, $data->boxprice);
$retailprice=mysqli_real_escape_string($con, $data->retailprice);
$wholesaleprice=mysqli_real_escape_string($con, $data->wholesaleprice);
$receiveday=mysqli_real_escape_string($con, $data->receiveday);
$expireday=mysqli_real_escape_string($con, $data->expireday);
$barcode=mysqli_real_escape_string($con, $data->barcode);
$userid = $_SESSION["id"];
$subbranchid = $_SESSION["subbranchid"];
$date1 = date_create($receiveday);
$receiveday = date_format($date1, 'Y-m-d H:i:s');
$date2 = date_create($expireday);
$expireday = date_format($date2, 'Y-m-d H:i:s');


$query1="INSERT INTO `stock`(`PO_No`,`productid`, `cid`, `remainfull`, `remain`, `lotno`, `stocktype`, `costprice`, `baseprice`, `boxprice`, `retailprice`, `wholesaleprice`, `receiveday`, `expireday`, `subbranchid`, `userid`,`barcode`) VALUES ('$poNO','$productid','$cid','$remain','$remain','$lotno','$stocktype','$costprice','$baseprice','$boxprice','$retailprice','$wholesaleprice','$receiveday','$expireday','$subbranchid','$userid','$barcode')";
/*$query="INSERT INTO stock
        (
        productid,
        cid,remainfull,
        remain,
        lotno,
        stocktype,
        costprice,
        baseprice,
        boxprice,
        retailprice,
        wholesaleprice,
        receiveday,userid,subbranchid,
        expireday)
        VALUES
        (
        '$productid',
        $cid,$remain,
        $remain,
        $lotno,
        '$stocktype',
        $costprice,
        $baseprice,
        $boxprice,
        $retailprice,
        $wholesaleprice,'$receiveday'
        ,'$userid','$subbranchid',
        '$expireday'";*/
//echo($query1);
if(mysqli_query($con, $query1)) {
    echo "Data Inserted";
}
else {
    echo "Insert Error";
}


$sqlup = "UPDATE rpt_POdetail SET sts = '0' WHERE rpt_POD_id =  $rpt_POD_id ";

if(mysqli_query($con,$sqlup)){

    echo "Data Update";
}