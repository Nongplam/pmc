<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$subid = $_SESSION['subbranchid'];


$sql = "SELECT product.pname,prePo.* FROM prePo,product WHERE prePo.productid = product.regno AND prePo.subbranchid = $subid";


if($result = mysqli_query($con,$sql)){
    $res = array();
    while ($row = $result ->fetch_array(1) ){
        $res[]  = $row;
    }
    $prePO['records'] =   $res;

    echo json_encode($prePO);
}else{


    echo mysqli_error($con);
}