<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 8:29 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$subid = $_SESSION['subbranchid'];

$sql = "SELECT rpt_PO.rptPO_no,rpt_recivePO.rptRecivePO_No,rpt_recivePO.recieive_Date,SUM(preToStock.status_remain) as status_remain,SUM(preToStock.status_detail) as status_detail,SUM(preToStock.status_price) as status_price 
FROM rpt_PO,rpt_recivePO,preToStock  

WHERE rpt_PO.rptPO_no = rpt_recivePO.rptPO_no AND rpt_PO.rptPO_no = preToStock.PO_No 
AND rpt_PO.subbranchid = rpt_recivePO.subbranchid AND  rpt_PO.subbranchid  = preToStock.subbranchid 
AND  rpt_PO.subbranchid = $subid

GROUP BY  rpt_PO.rptPO_no,rpt_recivePO.rptRecivePO_No";



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