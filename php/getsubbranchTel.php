<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

/*$data=json_decode(file_get_contents("php://input"));
$brandid=$data->brandid;
$output="";*/

//รับค่าผ่าน url
if(isset($_GET['branchid'])){
    $branchid=$_GET['branchid'];
    $query="select tel from subbranch WHERE id = '{$branchid}'";
    $result = mysqli_query($con,$query);    
    $product=array();
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($product,$rows['tel']);
    }
}
    echo $product[0];
