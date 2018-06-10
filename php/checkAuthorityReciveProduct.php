<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/6/2018
 * Time: 5:13 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

//$userid = $_SESSION['id'];
//$subid = $_SESSION['subbranchid'];

//echo json_encode($data);

$pass = mysqli_real_escape_string($con,$data->pass);

$po_no = mysqli_real_escape_string($con,$data->po_no);

        $stmt = $con->prepare("SELECT * FROM rpt_PO WHERE rptPO_no = ?");
        /* bind parameters for markers */
        $stmt->bind_param("s", $po_no);
        /* execute query */
        $stmt->execute();
        $result = $stmt->get_result();
        /* fetch value */
        $row= mysqli_fetch_assoc($result);







$res = array();
$res[] =  $row;
$PO['records']= $res;
echo   json_encode($PO);


/* close statement */
$stmt->close();







?>