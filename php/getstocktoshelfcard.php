<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
//$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];
$sql = "SELECT rpt_stocktoshelf.rptno,rpt_stocktoshelf.rptdate FROM rpt_stocktoshelf WHERE rpt_stocktoshelf.subbranchid = '$subid'";

    $res = array();
    //echo  $sql;
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $response['records']= $res;
        echo   json_encode($response);
    }
?>
