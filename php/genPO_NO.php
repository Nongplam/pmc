<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$subid = $_SESSION['subbranchid'];

$sql = "SELECT MAX(rpt_PO.rptPO_no) as rptPO_no FROM rpt_PO WHERE subbranchid = $subid";
$result = mysqli_query($con,$sql) ;



        if( $result->num_rows >0){

            $rowRptNo  = $result ->fetch_array(1);
            $rptNoD = $rowRptNo['rptPO_no'];
            $rptNo = sprintf("%'.010d", $rptNoD+1);



  echo          "{\"records\":[{
\"rptPO_no\":\"".$rptNo."\"
}]}";
               /// echo "{'rptPO_no':'".$rptNo."'}";

        }else{
            echo          "{\"records\":[{
\"rptPO_no\":\"0000000000\"
}]}";
        }
