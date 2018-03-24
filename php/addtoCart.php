<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));



if(!empty($_POST["stockid"])){
    $stockid = $_POST['stockid'];    
    $price = $_POST['price'];    
    $qty = $_POST['qty'];   
    $userid = $_POST['userid'];
    $subbranchid = $_POST['subbranchid'];
    
    $query="insert into pos(stockid,price,qty,userid,subbranchid) values('$stockid','$price','$qty','$userid','$subbranchid')";
        if(mysqli_query($con, $query)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }
}


