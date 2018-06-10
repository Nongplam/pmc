<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$subid= $_SESSION['subbranchid'];

  $sql = "SELECT rpt_PO.*,company.cname,rpt_PO_status.rpt_PO_status_desc FROM rpt_PO,company,rpt_PO_status WHERE rpt_PO.rptPO_status = rpt_PO_status.rpt_PO_status_s AND company.cid = rpt_PO.cid  AND subbranchid = $subid ORDER BY rptPO_date DESC";
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