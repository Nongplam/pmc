<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

/*$data=json_decode(file_get_contents("php://input"));
$brandid=$data->brandid;
$output="";*/

$query="select bname from brand";
$result = mysqli_query($con,$query);

$brand=array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($brand,$rows['bname']);
}

echo json_encode($brand);

//echo $rows["bname"];
