<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));



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
            printf("<br>");
        }
        else {
            echo "detail Error";
        }
    
    
}
$deleteposstm="DELETE FROM `pos` WHERE `pos`.`subbranchid` = '$subbranchid' AND `pos`.`userid` = '$userid'";
$deleteposexec= mysqli_query($con,$deleteposstm);
}
/*
$stm5="update stock set remain='$remainsum' where sid = '$stockid[$i]'";
$stm4="select remain from stock where sid = 1";
    $remainresult = mysqli_query($con,$stm4);    
    $remain=array();
    while ($remainrows = $remainresult->fetch_array(MYSQLI_ASSOC)){
        array_push($remain,$remainrows['remain']);
    }
printf("this is remain");
    printf($remain[0]);*/

/*
$res2 = mysqli_($resultstm2,0,"stockid");
echo $res2*/

/*$rows = mysql_num_rows($resule);
for ($i = 0; $i <=$rows-1 ;$i++){//start loop
$payment_way2 = mysql_result($resule,$i,"payment_way2");
$pay_icon = mysql_result($resule,$i,"pay_icon");
}//end loop*/
/*if(mysqli_query($con,$stm2)){
    
echo "query success";
        }
        else {
            echo "Error";
        }*/

?>
