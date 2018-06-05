<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$masterbranchid=$_SESSION["masterbranchid"];


$query="select * from company where masterbranchid = '$masterbranchid'";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = $rows;
}
$brand['records'] = $res;
echo json_encode($brand);
