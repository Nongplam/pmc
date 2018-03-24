<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

if($data) {
    //Query เมื่อข้อมูลเปลี่ยนแปลง
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
    $userid = $_SESSION["id"];
    $subbranchid = $_SESSION["subbranchid"];
    $date1 = date_create($receiveday);
    $receiveday = date_format($date1, 'Y-m-d H:i:s');
    $date2 = date_create($expireday);
    $expireday = date_format($date2, 'Y-m-d H:i:s');

    $btnName=$data->btnName; //สถานะปุ่ม    
    if ($btnName=="Insert") {
        $query1="INSERT INTO `stock`(`productid`, `cid`, `remainfull`, `remain`, `lotno`, `stocktype`, `costprice`, `baseprice`, `boxprice`, `retailprice`, `wholesaleprice`, `receiveday`, `expireday`, `subbranchid`, `userid`) VALUES ('$productid','$cid','$remain','$remain','$lotno','$stocktype','$costprice','$baseprice','$boxprice','$retailprice','$wholesaleprice','$receiveday','$expireday','$subbranchid','$userid')";
        $query="INSERT INTO stock
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
        '$expireday'";
        echo($query1);
        if(mysqli_query($con, $query1)) {
            echo "Data Inserted";
        }
        else {
            echo "Insert Error";
        }
    }
    if ($btnName=="Update") {
        $sid=mysqli_real_escape_string($con, $data->sid);
        $query="UPDATE stock
        SET
        productid = '$productid',
        cid = $cid,
        remain = $remain,
        lotno = $lotno,
        stocktype = '$stocktype',
        costprice = $costprice,
        baseprice = $baseprice,
        boxprice = $boxprice,
        retailprice = $retailprice,
        wholesaleprice = $wholesaleprice,
        userid = '$userid',
        receiveday = '$receiveday',
        expireday = '$expireday'
        WHERE sid = $sid 
        ";

        echo($query);
        if(mysqli_query($con, $query)) {
            echo "Data Updated";
        }
        else {
            echo "Error update";
        }
    }
}



?>
