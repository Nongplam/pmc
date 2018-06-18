<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$masterbranchid=$_SESSION["masterbranchid"];
$sql =  "SELECT rpt_stocktobranchstock.*,subbranch.name FROM rpt_stocktobranchstock,subbranch WHERE rpt_stocktobranchstock.subbranchid = subbranch.id AND rpt_stocktobranchstock.mbranchid =$masterbranchid";
if($result = mysqli_query($con,$sql)){
    while($row = $result -> fetch_array(1)){
        $res[] =  $row ;
    }
    $Oder['records']= $res;
    echo   json_encode($Oder);
}else{
    mysqli_error($con);
}