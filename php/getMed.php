<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

/*$data=json_decode(file_get_contents("php://input"));
$brandid=$data->brandid;
$output="";*/

//รับค่าผ่าน url
if(isset($_GET['brand'])){
    $brand=$_GET['brand'];
    $query="select pname from product INNER JOIN brand ON product.brandid=brand.bid WHERE brand.bname LIKE '{$brand}'";
    $result = mysqli_query($con,$query);
    $product=array();
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($product,$rows['pname']);
    }
}
    echo json_encode($product);
