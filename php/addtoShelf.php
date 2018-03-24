<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subbranchid = $_SESSION["subbranchid"];
$userid = $_SESSION["id"];
if($data){
    $word=$data->word;
    $stm1 = "SELECT shelfprepare.*,shelf.shelfcode,shelf.shelfinfo FROM shelfprepare,shelf WHERE shelfprepare.toshelfno = shelf.shelfno and shelfprepare.subbranchid = '$subbranchid' and shelf.subbranchid = '$subbranchid'";
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
    $stm2="insert into shelf(shelfno, shelfcode, stockid, shelfremain, shelfadddate, shelfinfo, subbranchid, userid) VALUES ('$shelfno','$shelfcode','$stockid','$qty',NOW(),'$shelfinfo','$subbranchid','$userid')";
    if(mysqli_query($con, $stm2)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }
    $stm3="select stock.remain from stock where stock.sid = '$stockid'";
    $result2 = mysqli_query($con,$stm3);
    $rows2 = $result2->fetch_array(MYSQLI_ASSOC);
    $remain = $rows2["remain"];
    $remaintemp = $remain - $qty;
    $stm4="update stock set stock.remain = '$remaintemp' where stock.sid = '$stockid'";
    mysqli_query($con, $stm4);
    
}
$deletepreshelfstm="DELETE FROM `shelfprepare` WHERE `shelfprepare`.`subbranchid` = '$subbranchid'";
$deletepreshelfexec= mysqli_query($con,$deletepreshelfstm);    
}
?>
