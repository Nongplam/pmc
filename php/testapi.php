<?php 
/*session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$subbranchid = $_SESSION["subbranchid"];
$userid = $_SESSION["id"];
$maxreportnumberquery="SELECT MAX(rpt_stocktoshelf.rptno) AS rptno FROM rpt_stocktoshelf WHERE rpt_stocktoshelf.subbranchid = 78";
    $maxreportnumberresult = mysqli_query($con, $maxreportnumberquery);
    $maxreportnumberrows = mysqli_fetch_assoc($maxreportnumberresult);
    if($maxreportnumberrows['rptno'] == NULL){
        $newreportid = sprintf("%010d", 1);
    }else{
        $newreportid = sprintf("%010d", $maxreportnumberrows['rptno']+1);
    } 
    $insertmainrptquery="INSERT INTO rpt_stocktoshelf(rptno, rptdesc, subbranchid, userid) VALUES ('$newreportid','ใบนำทาง','$subbranchid','$userid')";
    mysqli_query($con, $insertmainrptquery);

    $newrptidquery="SELECT rpt_stocktoshelf.rptid FROM rpt_stocktoshelf WHERE rpt_stocktoshelf.rptno = '$newreportid' AND rpt_stocktoshelf.subbranchid = '$subbranchid'";
    $newrptidresult = mysqli_query($con, $newrptidquery);
    $newrptidrows = mysqli_fetch_assoc($newrptidresult);
    $newrptid = $newrptidrows['rptid'];

    $insertsubrptquery="INSERT INTO rpt_stocktoshelfdetail (rptid,userid,stockid,qty,toshelfno,subbranchid) SELECT '$newrptid','$userid', shelfprepare.stockid,shelfprepare.qty,shelfprepare.toshelfno,shelfprepare.subbranchid FROM shelfprepare WHERE shelfprepare.subbranchid = '$subbranchid'";
    mysqli_query($con, $insertsubrptquery);*/

    

?>
