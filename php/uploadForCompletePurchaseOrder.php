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
$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$no = $_POST['no'] ;


$status  = 5;
$order = "PO";
$location = "../upload/$subid/$order/$no/$status";


include "upload.php";



if (!empty($filename_arr)) {
    $sql = "UPDATE rpt_PO SET rpt_PO.rptPO_status = 5 WHERE rpt_PO.rptPO_no = '$no' AND rpt_PO.subbranchid = $subid";
    
    

//    echo $sql;

    $result = array();
    if (mysqli_query($con, $sql)) {
        $result[0]['UpStsrpt_PO'] = true;
        
        $sql2 = "INSERT INTO Todolist(todotype, title, detail, url, usergen, userrecive) VALUES ('2','ตรวจรับสินค้า','ตรวจรับสินค้าเรียบร้อย $no','/pmc/showAllPurchaseOrder.php','$userid','46')";
        mysqli_query($con, $sql2)
        
        
    } else {
        $result[0]['UpStsrpt_PO'] = 'Failed = '.mysqli_error($con)."------".$sql;
    }

    $res["records"] = $result;
    echo   json_encode($res);
}
