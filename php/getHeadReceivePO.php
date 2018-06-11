<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 5:20 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


$no = mysqli_real_escape_string($con,$data->po_no);
$po_no =  sprintf("%'.010d", $no);

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];


$sql = "SELECT rpt_PO.*,company.cname,rpt_recivePO.* FROM rpt_PO,company,rpt_recivePO 
WHERE rpt_PO.rptPO_no = rpt_recivePO.rptPO_no 
AND rpt_PO.subbranchid = rpt_recivePO.subbranchid 
AND company.cid = rpt_PO.cid 
AND rpt_PO.rptPO_no = '$po_no' AND rpt_PO.subbranchid = $subid";




if($result = mysqli_query($con,$sql)){
    $row = $result -> fetch_array(1);
    echo json_encode($row);
}
