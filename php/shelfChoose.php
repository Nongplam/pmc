<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$subbranchid = $_SESSION["subbranchid"];

$query="SELECT shelf.* FROM shelf where shelf.subbranchid = '$subbranchid' GROUP BY shelf.shelfno";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){    
    $res[] = array('shelfid' =>$rows['shelfid'] , 'shelfno' => $rows['shelfno'],'shelfcode'=>$rows['shelfcode'],
    'shelfinfo'=>$rows['shelfinfo']
    );
} 

$shelf['records'] = $res;
echo json_encode($shelf);
