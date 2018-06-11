<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/10/2018
 * Time: 2:23 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];


$po_no = mysqli_real_escape_string($con,$data-> po_no);



$sql = "SELECT MAX(	rptRecivePO_No) as rptRecivePO_No FROM rpt_recivePO WHERE subbranchid = $subid";
$result = mysqli_query($con,$sql) ;



if( $result->num_rows >0){
    $rowRptNo  = $result ->fetch_array(1);
    $rptNoD = $rowRptNo['rptRecivePO_No'];
    $rptNo = sprintf("%'.010d", $rptNoD+1);
}else{
    $rptNo = "0000000000";
}


//echo $rptNo;


$sqlInset = "INSERT INTO rpt_recivePO( rptPO_no, rptRecivePO_No, rptRecivePO_Date, rptRecivePO_Status, subbranchid, userid) VALUES ('$po_no','$rptNo',now(),1,$subid,$userid)";
if(mysqli_query($con,$sqlInset)){


    $sqlInsertReceivePOdetail = "INSERT INTO rpt_recivePOdetail( rptPO_no, rptRecivePO_No, rpt_POD_id, subbranchid, userid) SELECT  '$po_no','$rptNo',rpt_POD_id, $subid, $userid FROM rpt_POdetail WHERE  rpt_POdetail.rptPO_no = '$po_no' AND rpt_POdetail.subbranchid = $subid ";

   if( mysqli_query($con,$sqlInsertReceivePOdetail)){



       $sqlUpdate = "UPDATE rpt_PO SET rpt_PO.rptPO_status = 4 WHERE rpt_PO.rptPO_no = '$po_no' AND rpt_PO.subbranchid = $subid";
       if( mysqli_query($con,$sqlUpdate)){


           $sqlInsetPreStock = " INSERT INTO preToStock (PO_No,productid,cid,stocktype,costprice,subbranchid,userid) SELECT rpt_POdetail.rptPO_no,rpt_POdetail.productid,rpt_PO.cid,rpt_POdetail.type,rpt_POdetail.pricePerType,$subid,$userid  FROM rpt_PO,rpt_POdetail  WHERE  rpt_PO.rptPO_no = rpt_POdetail.rptPO_no AND rpt_PO.subbranchid = rpt_POdetail.subbranchid AND  rpt_POdetail.rptPO_no = '$po_no' AND rpt_POdetail.subbranchid = $subid ";
           if(mysqli_query($con,$sqlInsetPreStock)){
               echo "{\"Insert\" : true}";
           }else{
               echo mysqli_error($con);
           }

       }
   }else{
       echo mysqli_error($con);
   }
}else{
    echo "{\"Insert\" : false}";
}


