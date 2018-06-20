<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subbranchid = $_SESSION["subbranchid"];
$userid = $_SESSION["id"];
if($data){
    $word=$data->word;
    $stm1 = "SELECT shelfprepare.*,shelf.shelfcode,shelf.shelfinfo FROM shelfprepare,shelf WHERE shelfprepare.toshelfno = shelf.shelfno and shelfprepare.subbranchid = '$subbranchid' and shelf.subbranchid = '$subbranchid' GROUP BY shelfprepare.id";
$result = mysqli_query($con,$stm1);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){    
    $res[] = array('id' =>$rows['id'] , 'stockid' => $rows['stockid'],'qty'=>$rows['qty'],
    'toshelfno'=>$rows['toshelfno'],'subbranchid'=>$rows['subbranchid'],'shelfcode'=>$rows['shelfcode'],
    'shelfinfo'=>$rows['shelfinfo']
    );
}

$countpreshelf = count($res);

for($i = 0;$i < $countpreshelf;$i++){
    $shelfno=$res[$i]['toshelfno'];
    $shelfcode=$res[$i]['shelfcode'];
    $stockid=$res[$i]['stockid'];
    $qty=$res[$i]['qty'];
    $shelfinfo=$res[$i]['shelfinfo'];
    $stm3="SELECT shelf.shelfid FROM shelf WHERE shelf.shelfno = '$shelfno' AND shelf.stockid = '$stockid' AND shelf.subbranchid = '$subbranchid'";
    $stm3result=mysqli_query($con, $stm3);
    $res3 = $stm3result->fetch_array(MYSQLI_ASSOC);    
    if($res3['shelfid'] > 0){   
        $shelfidtemp = $res3['shelfid'];
        $stm2="UPDATE shelf SET shelf.shelfremain = shelf.shelfremain+$qty WHERE shelf.shelfid = $shelfidtemp";
        if(mysqli_query($con, $stm2)) {
            echo "Data Updated";
        }
        else {
            echo "Error";
        }    
    $stm4="update stock set stock.remain = stock.remain-'$qty' where stock.sid = '$stockid'";
    mysqli_query($con, $stm4);  
        
    }else{
        $stm2="insert into shelf(shelfno, shelfcode, stockid, shelfremain, shelfadddate, shelfinfo, subbranchid, userid) VALUES ('$shelfno','$shelfcode','$stockid','$qty',NOW(),'$shelfinfo','$subbranchid','$userid')";
    if(mysqli_query($con, $stm2)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }    
    $stm4="update stock set stock.remain = stock.remain-'$qty' where stock.sid = '$stockid'";
    mysqli_query($con, $stm4);   
    }
    
    
}
    $maxreportnumberquery="SELECT MAX(rpt_stocktoshelf.rptno) AS rptno FROM rpt_stocktoshelf WHERE rpt_stocktoshelf.subbranchid = '$subbranchid'";
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
    mysqli_query($con, $insertsubrptquery);
    
    
    
    
$deletepreshelfstm="DELETE FROM `shelfprepare` WHERE `shelfprepare`.`subbranchid` = '$subbranchid'";
$deletepreshelfexec= mysqli_query($con,$deletepreshelfstm);
}
?>
