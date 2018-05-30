<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION["id"];
$subbranchid = $_SESSION["subbranchid"];

if($data){       
    $sumprice=mysqli_real_escape_string($con, $data->sumprice);
    $memberid=mysqli_real_escape_string($con, $data->memberid);
    $changemoney=mysqli_real_escape_string($con, $data->changemoney);
    $recivemoney=mysqli_real_escape_string($con, $data->recivemoney);
    $paymethod=mysqli_real_escape_string($con, $data->paymethod);
    $billkey = uniqid();
    
    $maxbillnoquery="SELECT MAX(billno) as billno FROM dailysalemaster WHERE dailysalemaster.subbranchid = '$subbranchid';";
    $maxbillnoresult = mysqli_query($con, $maxbillnoquery);
    $maxbillnorows = mysqli_fetch_assoc($maxbillnoresult);
    $newbillid = sprintf("%010d", $maxbillnorows['billno']+1);
    
    
    
    $stm1="insert into dailysalemaster(billno,sumprice,memberid,moneyreceive,moneychange,userid,subbranchid,paymethod,refkey) values('$newbillid','$sumprice','$memberid','$recivemoney','$changemoney','$userid','$subbranchid','$paymethod','$billkey')";
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
    echo $stocktemp;
    echo $qtytemp;
    $maxshelfidnoquery="SELECT MAX(shelfid) as maxshelfid FROM shelf WHERE shelf.stockid = '$stocktemp' AND shelf.subbranchid = '$subbranchid';";
    $maxshelfidnoresult = mysqli_query($con, $maxshelfidnoquery);
    $maxshelfidnorows = mysqli_fetch_assoc($maxshelfidnoresult);
    $maxshelfid = $maxshelfidnorows['maxshelfid'];
    
    
    
    $shelfremainquery="SELECT shelf.shelfremain FROM shelf WHERE shelf.shelfid = '$maxshelfid'";
    $shelfremainresult = mysqli_query($con, $shelfremainquery);
    $shelfremainrows = mysqli_fetch_assoc($shelfremainresult);
    $shelfremain = $shelfremainrows['shelfremain'];
    
    if($shelfremain == ""){
        $updatequery3="UPDATE stock SET stock.remain = stock.remain-$qtytemp WHERE stock.sid = '$stocktemp'";
        if(mysqli_query($con, $updatequery3)) {
            echo "detail Updated";            
        }
        else {
            echo "detail Error";
        }
        
    }else if($shelfremain >= $qtytemp){
        //$shelfremain = $shelfremain - $qtytemp;
        $updatequery="UPDATE shelf SET shelf.shelfremain = shelf.shelfremain-$qtytemp WHERE shelf.shelfid = '$maxshelfid'";
        if(mysqli_query($con, $updatequery)) {
            echo "detail Updated";            
        }
        else {
            echo "detail Error";
        }
        
    }else{
        $qtyaftershelf = $shelfremain - $qtytemp;
        $updatequery1="UPDATE shelf SET shelf.shelfremain = 0 WHERE shelf.shelfid = '$maxshelfid'";
        if(mysqli_query($con, $updatequery1)) {
            echo "detail Updated";            
        }
        else {
            echo "detail Error";
        }
        
        $updatequery2="UPDATE stock SET stock.remain = stock.remain+$qtyaftershelf WHERE stock.sid = '$stocktemp'";
        if(mysqli_query($con, $updatequery2)) {
            echo "detail Updated";            
        }
        else {
            echo "detail Error";
        }
        
        
    }
    
    
}
$deleteposstm="DELETE FROM `pos` WHERE `pos`.`subbranchid` = '$subbranchid' AND `pos`.`userid` = '$userid'";
$deleteposexec= mysqli_query($con,$deleteposstm);
}

?>
