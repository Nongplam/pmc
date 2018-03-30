<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 3/30/2018
 * Time: 3:05 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];
if($data) {

    $po_no = mysqli_real_escape_string($con,$data -> po_no);
    $po_date = mysqli_real_escape_string($con,$data -> po_date);
    $cid = mysqli_real_escape_string($con,$data -> cid);
    $po_agent = mysqli_real_escape_string($con,$data -> po_agent);
    $po_lo = mysqli_real_escape_string($con,$data ->po_lo);
    $po_tel = mysqli_real_escape_string($con,$data -> po_tel);
    $po_mail = mysqli_real_escape_string($con,$data -> po_mail);
    $po_vatno = mysqli_real_escape_string($con,$data -> po_vatno);
    $po_sendlo = mysqli_real_escape_string($con,$data -> po_sendlo);
    $po_datesend = mysqli_real_escape_string($con,$data -> po_datesend);
    $pricesum = mysqli_real_escape_string($con,$data -> pricesum);
    $pricediscount = mysqli_real_escape_string($con,$data -> pricediscount);
    $priceMIdicount = mysqli_real_escape_string($con,$data -> priceMIdicount);
    $pricevat = mysqli_real_escape_string($con,$data -> pricevat);
    $totalprice = mysqli_real_escape_string($con,$data -> totalprice);

echo $po_date."  ";
echo  $po_datesend;
    $sqlInPO = "INSERT INTO rpt_PO(rptPO_no, rptPO_date, cid, rptPO_agent, rptPO_lo, rptPO_tel, rptPO_mail, rptPO_vatNo, rptPO_losend, rptPO_datesend, pricesum, pricediscount, priceMIdicount, pricevat,totalprice, rptPO_status,subbranchid, userid) 
   VALUES ('$po_no','$po_date',$cid,'$po_agent','$po_lo','$po_tel','$po_mail','$po_vatno','$po_sendlo','$po_datesend',$pricesum,$pricediscount,$priceMIdicount,$pricevat,$totalprice,'1',$subid,$userid)";




}