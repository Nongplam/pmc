<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$userid = $_SESSION["id"];
if($data){
    $detail=mysqli_real_escape_string($con, $data->message);
    $userrecive=mysqli_real_escape_string($con, $data->userrecive);
    $sql = "INSERT INTO Todolist(todotype, title, detail, url, usergen, userrecive) VALUES ('1','ส่งสินค้าไปสาขาย่อย','$detail','/pmc/stockToStockBranchPre.php','$userid','$userrecive')";
    if(mysqli_query($con, $sql)) {
        echo "Data Inserted";
        
        }
        else {
            echo "error";
        }
}else{
    echo "error";
}
