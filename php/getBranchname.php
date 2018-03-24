<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

/*$data=json_decode(file_get_contents("php://input"));
$brandid=$data->brandid;
$output="";*/

//รับค่าผ่าน url


if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="select name from subbranch WHERE subbranch.id LIKE '{$id}'";
    $result = mysqli_query($con,$query);    
    $branchname=array();    
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($branchname,$rows['name']);
    }
}
    echo $branchname[0];
