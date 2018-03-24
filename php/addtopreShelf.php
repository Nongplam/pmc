<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
if($data){
$stockid=$data->stockid;
$qty=$data->qty;
$shelfno=$data->shelfno;
$subbranchid = $_SESSION["subbranchid"];
echo $stockid;
echo $qty;
echo $shelfno;
echo $subbranchid;
$query="insert into shelfprepare(stockid,qty,toshelfno,subbranchid) values('$stockid','$qty','$shelfno','$subbranchid')";

if(mysqli_query($con, $query)) {
            echo "Data Deleted";
        }
        else {
            echo "Error";
        }
}




