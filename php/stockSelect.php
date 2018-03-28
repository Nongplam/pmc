<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$subbranchid = $_SESSION["subbranchid"];

$query="SELECT stock.*,product.pname,company.cname FROM stock,company,product where stock.productid = product.regno and stock.cid = company.cid and stock.subbranchid = '$subbranchid' and stock.remain > 0";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('sid' =>$rows['sid'] , 'productid' => $rows['productid'],'pname'=>$rows['pname'],
    'cid'=>$rows['cid'],'cname'=>$rows['cname'],'remain'=>$rows['remain'],
    'lotno'=>$rows['lotno'],'stocktype'=>$rows['stocktype'],'costprice'=>$rows['costprice'],
    'baseprice'=>$rows['baseprice'],'boxprice'=>$rows['boxprice'],'retailprice'=>$rows['retailprice'],
    'wholesaleprice'=>$rows['wholesaleprice'],'receiveday'=>$rows['receiveday'],'expireday'=>$rows['expireday']
    );
}
$stock['records'] = $res;
echo json_encode($stock);
