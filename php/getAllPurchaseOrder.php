<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$subid= $_SESSION['subbranchid'];

  $sql = "SELECT rpt_PO.*,company.cname FROM rpt_PO,company WHERE company.cid = rpt_PO.cid  AND subbranchid = $subid ORDER BY rptPO_date DESC";
$res = array();
//echo  $sql;
if($result = mysqli_query($con,$sql)){

    while ($row = $result -> fetch_array(1)){

        $res[] =  $row ;

    }
    $PO['records']= $res;
    echo   json_encode($PO);
}else{
    echo mysqli_error($con);
}