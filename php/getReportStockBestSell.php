<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$id=$_GET['branch'];
    $query="SELECT stock.sid,product.pname,stock.productid,SUM(dailysaledetail.qty) as qtyall,(stock.remain+SUM(dailysaledetail.qty)) as remainall ,stock.stocktype,stock.receiveday FROM dailysaledetail ,stock,product WHERE dailysaledetail.stockid = stock.sid AND stock.productid = product.regno AND dailysaledetail.date >= DATE_ADD( NOW() , INTERVAL -30 DAY) AND dailysaledetail.subbranchid = ".$id." GROUP BY dailysaledetail.stockid,product.pname,stock.productid,stock.remain,stock.stocktype,stock.receiveday,stock.expireday ORDER BY qtyall DESC";
    $result = mysqli_query($con,$query);


    $res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('sid' =>$rows['sid'],'pname' =>$rows['pname'],'productid' =>$rows['productid'],'qtyall' =>$rows['qtyall'],'remainall' =>$rows['remainall']
    ,'stocktype' =>$rows['stocktype'],'receiveday' =>$rows['receiveday']);
}
$stocks['records'] = $res;
echo json_encode($stocks);
