<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION["id"];
$subbranchid = $_SESSION["subbranchid"];

    
if($data){
    $stockid=mysqli_real_escape_string($con, $data->stockid);
$price=mysqli_real_escape_string($con, $data->price);
$qty=mysqli_real_escape_string($con, $data->qty);
    
    
    $query="insert into pos(stockid,price,qty,userid,subbranchid) values('$stockid','$price','$qty','$userid','$subbranchid')";
        if(mysqli_query($con, $query)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }
}


