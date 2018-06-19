<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/19/2018
 
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];

$no = $_POST['no'] ;
$br = $_POST['br'] ;
//echo  $no;
$status  = 2;
$order = "TBS";
$location = "../../upload/$subid/$order/$no/$status"; //

include "upload.php";

if (!empty($filename_arr)) {
    $sql = "UPDATE rpt_stocktobranchstock SET rptsTbs_status=$status ,userid= $userid WHERE subbranchid=$br  AND rptsTbs_no='$no' ";

//    echo $sql;

    $result = array();
    if (mysqli_query($con, $sql)) {
        $result[0]['UpStsrpt_TBS'] = true;
    } else {
        $result[0]['UpStsrpt_TBS'] = 'Failed = '.mysqli_error($con)."------".$sql;
    }

    $res["records"] = $result;
    echo   json_encode($res);
}
