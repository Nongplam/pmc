<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

//$masterbranchid=$_SESSION["masterbranchid"];


$query="select * from rolesetting";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('rolename' =>$rows['rolename'] , 'rolethai' => $rows['rolethai']);
}
$role['records'] = $res;
echo json_encode($role);
