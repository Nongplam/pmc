<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/7/2018
 * Time: 8:41 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


$no = mysqli_real_escape_string($con,$data->no);
$po_no =  sprintf("%'.010d", $no);

$subid = $_SESSION['subbranchid'];


$sql = "SELECT product.pname,rpt_POdetail.* FROM rpt_POdetail,product WHERE rpt_POdetail.productid = product.regno AND  rpt_POdetail.subbranchid = $subid AND rpt_POdetail.rptPO_no = $po_no";

//echo $sql;
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

?>