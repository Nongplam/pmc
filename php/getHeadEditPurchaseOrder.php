<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/7/2018
 * Time: 7:35 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$no = mysqli_real_escape_string($con,$data->no);
$po_no =  sprintf("%'.010d", $no);



$stmt = $con->prepare("SELECT rpt_PO.*,company.cname FROM rpt_PO,company WHERE rpt_PO.cid = company.cid AND rpt_PO.rptPO_no = ?");
/* bind parameters for markers */
$stmt->bind_param("s",$po_no);
/* execute query */
$stmt->execute();
$result = $stmt->get_result();
/* fetch value */
$row= mysqli_fetch_assoc($result);


echo json_encode($row);
?>