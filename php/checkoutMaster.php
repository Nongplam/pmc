<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subbranchid=$_SESSION["subbranchid"];


if(!empty($_POST["sumprice"])){
    $sumprice = $_POST['sumprice'];        
    $memberid = $_POST['memberid'];
    echo $memberid;
    $changemoney = $_POST['changemoney'];
    $recivemoney = $_POST['recivemoney'];
    $userid = $_POST['userid'];
    $subbranchid = $_POST['subbranchid'];
    
    $stm1="insert into dailysalemaster(sumprice,memberid,moneyreceive,moneychange,userid,subbranchid) values('$sumprice','$memberid','$recivemoney','$changemoney','$userid','$subbranchid')";
        if(mysqli_query($con, $stm1)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }
    $salemasteridStm="select * from dailysalemaster";

$salemasteridresult = mysqli_query($con,$salemasteridStm);
    $salemasterid=array();
    while ($rows = $salemasteridresult->fetch_array(MYSQLI_ASSOC)){
        array_push($salemasterid,$rows['dmid']);
    }
$maxmasterid = max($salemasterid);
printf("ค่าสูงสุดของ masterid คือ : ") ;
printf($maxmasterid) ;
printf("<br>") ;

$stm2="select * from pos where pos.userid = '$userid'";

$resultstm2 = mysqli_query($con,$stm2);
$stockid = array();
$price = array();
$qty = array();
    while ($rows = $resultstm2->fetch_array(MYSQLI_ASSOC)){
        array_push($stockid,$rows['stockid']);
        array_push($price,$rows['price']);
        array_push($qty,$rows['qty']);
    } 
 
$poslist = count($stockid);
printf("จำนวนรายการใน pos คือ : ") ;
printf($poslist);
printf("<br>") ;

for($i = 0;$i < $poslist ;$i++){
    $stm3="insert into dailysaledetail(masterid,stockid,qty,price,userid,subbranchid) values('$maxmasterid','$stockid[$i]','$qty[$i]','$price[$i]','$userid','$subbranchid')";
        if(mysqli_query($con, $stm3)) {
            echo "detail Inserted";            
        }
        else {
            echo "detail Error";
        }
    $qtytemp=$qty[$i];
    $stocktemp=$stockid[$i];
    $stm4="UPDATE shelf SET shelf.shelfremain = shelf.shelfremain-$qtytemp WHERE shelf.stockid = '$stocktemp' AND shelf.subbranchid = '$subbranchid'";
    if(mysqli_query($con, $stm4)) {
            echo "detail Updated";            
        }
        else {
            echo "detail Error";
        }
    
    
}
$deleteposstm="DELETE FROM `pos` WHERE `pos`.`subbranchid` = '$subbranchid' AND `pos`.`userid` = '$userid'";
$deleteposexec= mysqli_query($con,$deleteposstm);
}

?>
