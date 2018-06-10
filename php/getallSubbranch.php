<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$masterbranchid=$_SESSION["masterbranchid"];


$query="select * from subbranch where subbranch.mid = '$masterbranchid'";
if($result = mysqli_query($con,$query)){

    while ($row = $result -> fetch_array(1)){

        $res[] =  $row ;

    }
    $PO['records']= $res;
    echo   json_encode($PO);
}else{
    echo mysqli_error($con);
}

?>
