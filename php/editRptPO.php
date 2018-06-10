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

        $cid = mysqli_real_escape_string($con, $data->cid);


        $po_agent = mysqli_real_escape_string($con, $data->po_agent);



        $po_lo = mysqli_real_escape_string($con, $data->po_lo);



        $po_tel = mysqli_real_escape_string($con, $data->po_tel);



        $po_mail = mysqli_real_escape_string($con, $data->po_mail);




        $po_sendlo = mysqli_real_escape_string($con, $data->po_sendlo);



        $po_datesend = mysqli_real_escape_string($con, $data->po_datesend);


    $pricesum = mysqli_real_escape_string($con, $data->pricesum);
    $pricediscount = mysqli_real_escape_string($con, $data->pricediscount);
    $priceMIdicount = mysqli_real_escape_string($con, $data->priceMIdicount);
    $pricevat = mysqli_real_escape_string($con, $data->pricevat);
    $totalprice = mysqli_real_escape_string($con, $data->totalprice);
    $note  = mysqli_real_escape_string($con,$data->note);
    $dicount = mysqli_real_escape_string($con,$data -> discount);
    $vat = mysqli_real_escape_string($con,$data -> vat );
    $enc = md5($po_no);
    $sql = "UPDATE rpt_PO SET cid=$cid,
rptPO_agent='$po_agent',
rptPO_lo='$po_lo',
rptPO_tel='$po_tel',
rptPO_mail='$po_mail',
discount=$dicount,
rptPO_losend='$po_sendlo',
rptPO_date='$po_date',
rptPO_datesend='$po_datesend',
pricesum=$pricesum,
pricediscount=$pricediscount,
priceMIdicount=$priceMIdicount,
vat=$vat,
pricevat=$pricevat,
totalprice=$totalprice,
note='$note',
userid= $userid 
WHERE rptPO_no ='$po_no' AND subbranchid= $subid
";



    $result = array();
    if (mysqli_query($con, $sql)) {
        $result[0]['Uprpt_PO'] = true;
    } else {
        $result[0]['Uprpt_PO'] = 'Failed = '.mysqli_error($con)."------".$sql;
    }

            $res["records"] = $result;
    echo   json_encode($res);
}