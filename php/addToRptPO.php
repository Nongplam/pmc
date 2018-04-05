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

    $po_no = mysqli_real_escape_string($con, $data->po_no);
    $po_date = mysqli_real_escape_string($con, $data->po_date);
    try {
        $cid = mysqli_real_escape_string($con, $data->cid);
    } catch (mysqli_sql_exception $e) {
        $cid = "-";
    }

    try {
        $po_agent = mysqli_real_escape_string($con, $data->po_agent);
    } catch (mysqli_sql_exception $e) {
        $po_agent = "-";
    }

    try {
        $po_lo = mysqli_real_escape_string($con, $data->po_lo);
    } catch (mysqli_sql_exception $e) {
        $po_lo = "-";
    }

    try {
        $po_tel = mysqli_real_escape_string($con, $data->po_tel);
    } catch (mysqli_sql_exception $e) {
        $po_tel = "-";
    }

    try {
        $po_mail = mysqli_real_escape_string($con, $data->po_mail);
    } catch (mysqli_sql_exception $e) {
        $po_mail = "-";
    }

    try {
        $po_vatno = mysqli_real_escape_string($con, $data->po_vatno);
    } catch (mysqli_sql_exception $e) {
        $po_vatno = "-";
    }
    try {
        $po_sendlo = mysqli_real_escape_string($con, $data->po_sendlo);
    } catch (mysqli_sql_exception $e) {
        $po_sendlo = "-";
    }

    try {
        $po_datesend = mysqli_real_escape_string($con, $data->po_datesend);
    } catch (mysqli_sql_exception $e) {
        $po_datesend = "0000-00-00";
    }

    $pricesum = mysqli_real_escape_string($con, $data->pricesum);
    $pricediscount = mysqli_real_escape_string($con, $data->pricediscount);
    $priceMIdicount = mysqli_real_escape_string($con, $data->priceMIdicount);
    $pricevat = mysqli_real_escape_string($con, $data->pricevat);
    $totalprice = mysqli_real_escape_string($con, $data->totalprice);


    $sqlInPO = "INSERT INTO rpt_PO(rptPO_no, rptPO_date, cid, rptPO_agent, rptPO_lo, rptPO_tel, rptPO_mail, rptPO_vatNo, rptPO_losend, rptPO_datesend, pricesum, pricediscount, priceMIdicount, pricevat,totalprice, rptPO_status,subbranchid, userid) 
   VALUES ('$po_no','$po_date',$cid,'$po_agent','$po_lo','$po_tel','$po_mail','$po_vatno','$po_sendlo','$po_datesend',$pricesum,$pricediscount,$priceMIdicount,$pricevat,$totalprice,'1',$subid,$userid)";

    $result = array();
    if (mysqli_query($con, $sqlInPO)) {
        $result[0]['addrpt_PO'] = 'Successed';
    } else {
        $result[0]['addrpt_PO'] = 'Failed = '.mysqli_error($con)."------".$sqlInPO;
    }
echo   json_encode($result);
}