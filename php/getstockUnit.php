<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

/*$data=json_decode(file_get_contents("php://input"));
$brandid=$data->brandid;
$output="";*/

//รับค่าผ่าน url


if(isset($_GET['stockid'])){
    $stockid=$_GET['stockid'];
    $query="select stocktype from stock WHERE stock.sid LIKE '{$stockid}'";
    $result = mysqli_query($con,$query);    
    $product=array();
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($product,$rows['stocktype']);
    }
}
    echo $product[0];
