<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$id=$_GET['branch'];
    $query="SELECT  stock.sid,product.pname ,stock.productid,brand.bname,company.cname,stock.remain,stock.stocktype,stock.costprice,stock.lotno,stock.receiveday,stock.expireday 
    FROM stock,product,company,brand WHERE (stock.productid = product.regno AND stock.cid = company.cid AND product.brandid = brand.bid) 
    AND DATE(stock.expireday) >= NOW() AND stock.remain != 0 AND stock.subbranchid = ".$id." ORDER BY stock.remain ASC";
    $result = mysqli_query($con,$query);    


    $res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('sid' =>$rows['sid'],'pname' =>$rows['pname'],'productid' =>$rows['productid'],'bname' =>$rows['bname'],'cname' =>$rows['cname'],'remain' =>$rows['remain']
    ,'stocktype' =>$rows['stocktype'],'costprice' =>$rows['costprice'],'lotno' =>$rows['lotno'],'receiveday' =>$rows['receiveday'],'expireday' =>$rows['expireday'] );
}
$stocks['records'] = $res;
echo json_encode($stocks);