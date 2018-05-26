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
    
    $searchdupQuery="SELECT * FROM `pos` WHERE `stockid` = '$stockid' AND `subbranchid` = '$subbranchid'";
    $dupresult = mysqli_query($con,$searchdupQuery);
    
    $dup=array();
    $oldqtyarr=array();
    while ($rows = $dupresult->fetch_array(MYSQLI_ASSOC)){
    array_push($dup,$rows['id']);
    array_push($oldqtyarr,$rows['qty']);
    }
        
    if(sizeof($dup) != 0){
        $posid = $dup[0];
        $oldqty = $oldqtyarr[0];
        $newqty = $qty + $oldqty;
        $query="UPDATE `pos` SET `qty` = '$newqty' WHERE `pos`.`id` = '$posid'";
        if(mysqli_query($con, $query)) {
            echo "Data Updated";
        }
        else {
            echo "Error";
        }
    }else{
        $query="insert into pos(stockid,price,qty,userid,subbranchid) values('$stockid','$price','$qty','$userid','$subbranchid')";
        if(mysqli_query($con, $query)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }
    }  
}
