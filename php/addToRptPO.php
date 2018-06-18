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
    if($dicount > 0 ){
        $datePayMent = mysqli_real_escape_string($con,$data -> po_datePayMent );
        $sqlInPO = "INSERT INTO rpt_PO(rptPO_no,rptPO_noENC, rptPO_date, cid, rptPO_agent, rptPO_lo, rptPO_tel, rptPO_mail,  rptPO_losend, rptPO_datesend,rptPO_datePayMent, pricesum,discount, pricediscount, priceMIdicount,vat, pricevat,totalprice,note, rptPO_status,subbranchid, userid) 
        VALUES ('$po_no','$enc','$po_date',$cid,'$po_agent','$po_lo','$po_tel','$po_mail','$po_sendlo','$po_datesend','$datePayMent',$pricesum,$dicount,$pricediscount,$priceMIdicount,$vat,$pricevat,$totalprice,'$note','1',$subid,$userid)";

    }else{
        $sqlInPO = "INSERT INTO rpt_PO(rptPO_no,rptPO_noENC, rptPO_date, cid, rptPO_agent, rptPO_lo, rptPO_tel, rptPO_mail,  rptPO_losend, rptPO_datesend, pricesum,discount, pricediscount, priceMIdicount,vat, pricevat,totalprice,note, rptPO_status,subbranchid, userid) 
   VALUES ('$po_no','$enc','$po_date',$cid,'$po_agent','$po_lo','$po_tel','$po_mail','$po_sendlo','$po_datesend',$pricesum,$dicount,$pricediscount,$priceMIdicount,$vat,$pricevat,$totalprice,'$note','1',$subid,$userid)";
    }


   // $datePayMent = ($dicount != 0) ? mysqli_real_escape_string($con,$data -> po_datePayMent ) : null;
    



 


   

    $result = array();
      if (mysqli_query($con, $sqlInPO)) {
        $result[0]['addrpt_PO'] = true;

        $sqlInPOD = "INSERT INTO rpt_POdetail( rptPO_no, productid, remain, type, pricePerType, note, priceall, sts,subbranchid, userid) SELECT '$po_no',productid, remain, type, pricePerType, note, priceall,'1',$subid,$userid FROM prePo WHERE prePo.subbranchid = $subid";

        if (mysqli_query($con, $sqlInPOD)) {
            $result[0]['addrpt_POD'] = true;
        } else {
            $result[0]['addrpt_POD'] = 'Failed = '.mysqli_error($con)."------".$sqlInPOD;
        }

        $sqlDelPrePO = "DELETE FROM prePo WHERE subbranchid = $subid";


        if (mysqli_query($con, $sqlDelPrePO)) {
            $result[0]['DelPrePO'] = true;
        } else {
            $result[0]['DelPrePO'] = 'Failed = '.mysqli_error($con)."------".$sqlDelPrePO;
        }


    } else {
        $result[0]['addrpt_PO'] = 'Failed = '.mysqli_error($con)."------".$sqlInPO;
    }

            $res["records"] = $result;

echo   json_encode($res);
}