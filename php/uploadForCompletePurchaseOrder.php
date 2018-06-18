<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/10/2018
 * Time: 3:41 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
date_default_timezone_set("Asia/Bangkok");
$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$no = $_POST['no'] ;
$status = $_POST["status"];



$order = "PO";
$location = "../upload/$subid/$order/$no/$status";
include "upload.php";

if (!empty($filename_arr)) {

    // update status purchaseOrder 
    $sql = "UPDATE rpt_PO SET rpt_PO.rptPO_status = $status WHERE rpt_PO.rptPO_no = '$no' AND rpt_PO.subbranchid = $subid";
//    echo $sql;

    $result = array();
    if (mysqli_query($con, $sql)) {
        $result[0]['UpStsrpt_PO'] = true;
        // get id owner
        $sqlSelectIdOwner = "SELECT user.id FROM user WHERE user.role LIKE '%owner%' AND user.subbranchid = $subid";
        $resultID =  mysqli_query($con,$sqlSelectIdOwner);
        $row  = $resultID -> fetch_array(1);
        $idOwner = $row["id"];
        //add warning to todo list
        $sql2 = "INSERT INTO Todolist(todotype, title, detail, url, usergen, userrecive) VALUES ('2','ตรวจรับสินค้า','ตรวจรับสินค้าใบสั่งซื้อเลขที่ $no แล้ว','/pmc/showAllPurchaseOrder.php','$userid','$idOwner')";
        if(mysqli_query($con, $sql2)){
            $result[0]['InsertToDoList'] = true;
           }else{
            $result[0]['InsertToDoList'] = 'Failed = '.mysqli_error($con);
           }
        // update status receive purchaseOrder
        $sqlUpStatusReceive = "UPDATE rpt_recivePO SET rpt_recivePO.rptRecivePO_Status = 2 WHERE rpt_recivePO.rptPO_no = '$no' AND rpt_recivePO.subbranchid = $subid";
        if(mysqli_query($con, $sqlUpStatusReceive)){
            $result[0]['UpStatusReceivePO'] = true;
           }else{
            $result[0]['UpStatusReceivePO'] = 'Failed = '.mysqli_error($con);
           }
        
        //get id rpt_po
        $sqlSelectIdrptPO = "SELECT rpt_PO.rptPO_id FROM rpt_PO WHERE rpt_PO.rptPO_no = '$no' AND rpt_PO.subbranchid = $subid";
        $resultRptPoId = mysqli_query($con,$sqlSelectIdrptPO);
        $rowRptPoId = $resultRptPoId -> fetch_array(1);
        $rptPoId = $rowRptPoId["rptPO_id"];
        //get deff day of send product
        $sqlSelectDeff = "SELECT  DATEDIFF( rpt_recivePO.recieive_Date,rpt_PO.rptPO_datesend) AS date , (rpt_PO.totalprice*0.1)/100 AS price , DATEDIFF( rpt_recivePO.recieive_Date,rpt_PO.rptPO_datesend)*( (rpt_PO.totalprice*0.1)/100) AS total 
        FROM rpt_PO,rpt_recivePO 
        WHERE rpt_PO.rptPO_no = rpt_recivePO.rptPO_no 
        AND rpt_PO.subbranchid = rpt_recivePO.subbranchid 
        AND rpt_PO.rptPO_no = '$no' 
        AND rpt_PO.subbranchid = $subid";
        $resultDeff = mysqli_query($con,$sqlSelectDeff);
        $rowDeff = $resultDeff->fetch_array(1);
        $dateDeff = $rowDeff["date"];
        $price = $rowDeff["total"];
        //check late send product
        if($dateDeff > 0 ){
            //add price of fine
            $sqlInsertFine = "INSERT INTO rpt_PO_fine( rptPO_id, date, price, subbranchid, userid) VALUES ($rptPoId, $dateDeff,$price,$subid,$userid)";
            if(mysqli_query($con,$sqlInsertFine)){
                $result[0]['InsertFineDateDiff'] = true;
               }else{
                $result[0]['InsertFineDateDiff'] = 'Failed = '.mysqli_error($con);
               }
        }
        //add product receive incomplete to list of product for create new pusrchaseOrder
        $sqlIncomplete = "INSERT INTO productIncomplete(rptPO_no, rpt_POD_id, qty, subbranchid, userid) SELECT item.rptPO_no,item.rpt_POD_id,item.qty,$subid,$userid
                            FROM (SELECT rpt_POdetail.*,(rpt_POdetail.remain - rpt_recivePOdetail.rptRecivePOdetailI_Qty) AS qty FROM rpt_POdetail,rpt_recivePOdetail WHERE rpt_POdetail.rpt_POD_id = rpt_recivePOdetail.rpt_POD_id AND rpt_POdetail.rptPO_no = rpt_recivePOdetail.rptPO_no AND rpt_POdetail.subbranchid = rpt_recivePOdetail.subbranchid AND rpt_POdetail.rptPO_no = '$no' AND rpt_POdetail.subbranchid =  $subid ) as item
                            WHERE item.qty != 0";
        if(mysqli_query($con, $sqlIncomplete)){
            $result[0]['InsertProductIncomplete'] = true;
           }else{
            $result[0]['InsertProductIncomplete'] = 'Failed = '.mysqli_error($con);
           }
        //get count row of product incomplete if row > 0 add new purchaseOrder
        $sqlSelectRowCount = "SELECT COUNT( productIncomplete.id) AS rowcount FROM productIncomplete WHERE productIncomplete.rptPO_no = '$no' AND productIncomplete.subbranchid = $subid";
        $resultRowCount = mysqli_query($con,$sqlSelectRowCount);
        $rowRowCount = $resultRowCount -> fetch_array(1);
        $rowCount = $rowRowCount["rowcount"];
        //check row of produnc Incomplete > 0 
        if($rowCount > 0){
            //get new PO number
            $sqlGenPoNO = "SELECT MAX(rpt_PO.rptPO_no) as rptPO_no FROM rpt_PO WHERE subbranchid = $subid";
            $resultPoNO = mysqli_query($con,$sqlGenPoNO);
            if( $resultPoNO->num_rows >0){
                $rowRptNo  = $resultPoNO ->fetch_array(1);
                $rptNoD = $rowRptNo['rptPO_no'];
                $rptNo = sprintf("%'.010d", $rptNoD+1);
            }
            //get discount and vat
            $sqlGetDiscountAandVat = "SELECT rpt_PO.discount,rpt_PO.vat FROM rpt_PO WHERE rpt_PO.rptPO_no = '$no' AND rpt_PO.subbranchid = $subid";
            $resultDiscountAndPoNO = mysqli_query($con,$sqlGetDiscountAandVat);
            $rowDiscountAndVat = $resultDiscountAndPoNO -> fetch_array(1);
            $discount = $rowDiscountAndVat["discount"];
            $vat = $rowDiscountAndVat["vat"];
            //get price prie sum product incomplete
            $sqlGetPriceSum = "SELECT SUM(item.qty*item.pricePerType) AS pricesum
            FROM (SELECT rpt_POdetail.*,(rpt_POdetail.remain - rpt_recivePOdetail.rptRecivePOdetailI_Qty) AS qty 
                          FROM rpt_POdetail,rpt_recivePOdetail 
                          WHERE rpt_POdetail.rpt_POD_id = rpt_recivePOdetail.rpt_POD_id 
                          AND rpt_POdetail.rptPO_no = rpt_recivePOdetail.rptPO_no 
                          AND rpt_POdetail.subbranchid = rpt_recivePOdetail.subbranchid 
                          AND rpt_POdetail.rptPO_no = '$no' 
                          AND rpt_POdetail.subbranchid =  $subid ) as item
            WHERE item.qty != 0
            GROUP BY item.rptPO_no,item.subbranchid";
            $resultPriceSum = mysqli_query($con,$sqlGetPriceSum);
            $rowPriceSum = $resultPriceSum ->fetch_array(1);
            $pricesum = $rowPriceSum["pricesum"];
            $pricediscount = ($pricesum*$discount)/100.00 ;// calculat price of discount
            $priceMIdicount = $pricesum - $pricediscount;// calculate price sum minus price discount
            $pricevat =  ($priceMIdicount * $vat)/100.00; //calculate price of vat
            $totalprice = $priceMIdicount+ $pricevat ;// calculat total price

            //add new purchaseOrder ref old purchaseOrder
            $sqlInsertNewPurchaseOrder = "INSERT INTO rpt_PO( rptPO_no, rptPO_noENC, cid, rptPO_agent, rptPO_lo, rptPO_tel, rptPO_mail, discount, rptPO_losend, rptPO_date, rptPO_datesend, rptPO_datePayMent, pricesum, pricediscount, priceMIdicount, vat, pricevat, totalprice, note, rptPO_status, authority1, authority2, authority3, subbranchid, userid) 
                                            SELECT  '$rptNo','".md5($rptNo)."',rpt_PO.cid,rpt_PO.rptPO_agent,rpt_PO.rptPO_lo,rpt_PO.rptPO_tel,rpt_PO.rptPO_mail,rpt_PO.discount,rpt_PO.rptPO_losend,'".date('Y-m-d')."','".date('Y-m-d', strtotime("+7 days"))."',rpt_PO.rptPO_datePayMent,$pricesum,$pricediscount,$priceMIdicount,rpt_PO.vat,$pricevat,$totalprice,rpt_PO.note,1,rpt_PO.authority1,rpt_PO.authority2,rpt_PO.authority3,rpt_PO.subbranchid,$userid 
                                            FROM rpt_PO WHERE rpt_PO.rptPO_no = '$no' AND rpt_PO.subbranchid = $subid";
           if( mysqli_query($con, $sqlInsertNewPurchaseOrder)){
            $result[0]['InsertNewPO'] = true;
           }else{
            $result[0]['InsertNewPO'] = 'Failed = '.mysqli_error($con);
           }
           //add new Detail of new PurchaseOrder
            $sqlInsertNewDetailPurchaseOrder = "INSERT INTO rpt_POdetail( rptPO_no, productid, remain, type, pricePerType, note, priceall, sts, subbranchid, userid) 
                                                SELECT '$rptNo',item.productid,item.qty,item.type,item.pricePerType,item.note,(item.qty*item.pricePerType) AS priceall,item.sts,item.subbranchid,$userid
                                                FROM (SELECT rpt_POdetail.*,(rpt_POdetail.remain - rpt_recivePOdetail.rptRecivePOdetailI_Qty) AS qty 
                                                            FROM rpt_POdetail,rpt_recivePOdetail 
                                                            WHERE rpt_POdetail.rpt_POD_id = rpt_recivePOdetail.rpt_POD_id 
                                                            AND rpt_POdetail.rptPO_no = rpt_recivePOdetail.rptPO_no 
                                                            AND rpt_POdetail.subbranchid = rpt_recivePOdetail.subbranchid 
                                                            AND rpt_POdetail.rptPO_no = '$no' 
                                                            AND rpt_POdetail.subbranchid =  $subid ) as item
                                                WHERE item.qty != 0";
            if(mysqli_query($con,$sqlInsertNewDetailPurchaseOrder)){
                $result[0]['InsertNewDetailPO'] = true;
               }else{
                $result[0]['InsertNewDetailPO'] = 'Failed = '.mysqli_error($con);
               }
            $finePrieIncomeplete =  ($totalprice*0.1)/100.00;//calculate fine of product incomplete
            //add reference Old PO  and price of fine product incomplete
            $sqslInsertFineIncomplete = "INSERT INTO rpt_PO_fine_Incomplete(rptPO_no_ref, rptPO_no, priece, date, subbranchid, userid) VALUES ('$no','$rptNo',$finePrieIncomeplete ,NOW(),$subid,$userid)";
            if(mysqli_query($con,$sqslInsertFineIncomplete)){
                $result[0]['InsertFinceIncomplete'] = true;
               }else{
                $result[0]['InsertFinceIncomplete'] = 'Failed = '.mysqli_error($con);
               }
        }else{
            $sqlSelectRef = "SELECT rpt_PO_fine_Incomplete.* FROM rpt_PO_fine_Incomplete WHERE rpt_PO_fine_Incomplete.rptPO_no = '$no' AND rpt_PO_fine_Incomplete.subbranchid = $subid";
            $resultRef = mysqli_query($con,$sqlSelectRef);
            if( $resultRef ->num_rows >0){
                $rowRef = $resultRef -> fetch_array(1);
                $refPo_No = $rowRef["rptPO_no_ref"];
                $sqlUpstsPoRef = "UPDATE rpt_PO SET rpt_PO.rptPO_status = $status WHERE rpt_PO.rptPO_no = '$refPo_No' AND rpt_PO.subbranchid = $subid";
               if ( mysqli_query($con,$sqlUpstsPoRef)){
                $result[0]['UpstsPoRef'] = true;
               }else{
                $result[0]['UpstsPoRef'] = 'Failed = '.mysqli_error($con);
               }
            }
        }
      
        
    } else {
        $result[0]['UpStsrpt_PO'] = 'Failed = '.mysqli_error($con)."------".$sql;
    }

    $res["records"] = $result;
    echo   json_encode($res);
}
