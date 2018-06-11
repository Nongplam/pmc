<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 1:39 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


$no = mysqli_real_escape_string($con,$data->po_no);
$po_no =  sprintf("%'.010d", $no);

$subid = $_SESSION['subbranchid'];


$sql = "SELECT rpt_POdetail.*,product.pname,rpt_recivePOdetail.*,preToStock.* FROM product,rpt_recivePOdetail,rpt_POdetail LEFT JOIN preToStock  ON rpt_POdetail.rptPO_no = preToStock.PO_No AND rpt_POdetail.subbranchid = preToStock.subbranchid  AND rpt_POdetail.productid = preToStock.productid  
WHERE  
rpt_POdetail.rptPO_no = rpt_recivePOdetail.rptPO_no 
AND rpt_POdetail.subbranchid = rpt_recivePOdetail.subbranchid 
AND rpt_POdetail.rpt_POD_id = rpt_recivePOdetail.rpt_POD_id AND  rpt_POdetail.productid = product.regno
AND rpt_POdetail.rptPO_no = '$po_no' 
AND rpt_POdetail.subbranchid = $subid ORDER BY product.pname ASC";

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