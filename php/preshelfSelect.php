<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$subbranchid = $_SESSION["subbranchid"];

$query="SELECT shelfprepare.*,stock.productid,stock.lotno,product.pname,product.pcore,shelf.shelfinfo FROM shelfprepare,stock,product,shelf where shelfprepare.toshelfno = shelf.shelfno and shelfprepare.stockid = stock.sid and stock.productid = product.regno and shelfprepare.subbranchid = '$subbranchid' and shelfprepare.subbranchid = shelf.subbranchid GROUP by shelfprepare.id";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('id' =>$rows['id'] , 'stockid' => $rows['stockid'],'qty'=>$rows['qty'],
    'toshelfno'=>$rows['toshelfno'],'subbranchid'=>$rows['subbranchid'],'productid'=>$rows['productid'],
    'lotno'=>$rows['lotno'],'pname'=>$rows['pname'],'pcore'=>$rows['pcore'],'shelfinfo'=>$rows['shelfinfo']
    );
}
$preshelf['records'] = $res;
echo json_encode($preshelf);
