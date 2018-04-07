<?php
/**
 * Created by PhpStorm.
 * User: Abadon

 */



session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {
    $po_no= mysqli_real_escape_string($con, $data->po_no);
   $sql = "SELECT rpt_POdetail.rpt_POD_id,rpt_PO.cid,rpt_POdetail.rptPO_no, rpt_POdetail.productid,product.pname,rpt_POdetail.remain,rpt_POdetail.type,rpt_POdetail.pricePerType FROM rpt_PO,rpt_POdetail,product WHERE rpt_PO.rptPO_no = rpt_POdetail.rptPO_no AND rpt_POdetail.productid = product.regno AND rpt_POdetail.rptPO_no = $po_no AND rpt_POdetail.sts != '0' ORDER BY product.pname ASC";

    $res = array();
    //echo  $sql;
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $PO['records']= $res;
        echo   json_encode($PO);
    }
}