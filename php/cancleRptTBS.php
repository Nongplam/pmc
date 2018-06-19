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
$data=json_decode(file_get_contents("php://input"));

$status = 3;


$no = mysqli_real_escape_string($con,$data->no);


$sqlUpdate = "UPDATE rpt_stocktobranchstock SET rptsTbs_status=$status ,userid= $userid WHERE rptsTbs_id = $no ";
$result = array();
if(mysqli_query($con,$sqlUpdate)){
        $result[0]['UpStsrpt_TBS'] = true;
    
    $sqlRe ="UPDATE stock AS s INNER JOIN rpt_stocktobranchstockdetail AS r SET s.remain = s.remain+r.rptsTbs_qty WHERE s.sid = r.stockid AND r.rptsTbs_id = $no ";
       if(mysqli_query($con,$sqlRe)){
            $result[0]['ReStoreStock'] = true;
       }else{
            $result[0]['ReStoreStock'] = 'Failed = '.mysqli_error($con)."------".$sql;
       } 
    
    } else {
        $result[0]['UpStsrpt_TBS'] = 'Failed = '.mysqli_error($con)."------".$sql;
    }

    $res["records"] = $result;
    echo   json_encode($res);






?>
