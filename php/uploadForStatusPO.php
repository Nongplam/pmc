<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/8/2018
 * Time: 7:12 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$no = $_POST['no'] ;
$flag = $_POST['flag'] ;

if($flag == 2){
    $note =  $_POST['note'] ;
  //  $note  = "<br>หมายเหตุยกเลิกใบสั่งสินค้า<br>$note<br>";

    $po_note = ", a.note = concat(b.note,'<br>หมายเหตุยกเลิกใบสั่งสินค้า<br>$note<br>') ";
}else{
    $po_note = "";
}




//echo  $no;


$status  = $flag+1;
$order = "PO";
$location = "../upload/$subid/$order/$no/$status"; //

include "upload.php";

if (!empty($filename_arr)) {
    $sql = "UPDATE rpt_PO AS a INNER JOIN rpt_PO AS b 
            SET a.rptPO_status =  $status ,
            a.userid = $userid
            $po_note
            WHERE a.rptPO_no = '$no' 
            AND a.subbranchid = $subid
            AND  b.rptPO_no = '$no' 
            AND b.subbranchid = $subid";

//    echo $sql;

    $result = array();
    if (mysqli_query($con, $sql)) {
        $result[0]['UpStsrpt_PO'] = true;
    } else {
        $result[0]['UpStsrpt_PO'] = 'Failed = '.mysqli_error($con)."------".$sql;
    }

    $res["records"] = $result;
    echo   json_encode($res);
}


