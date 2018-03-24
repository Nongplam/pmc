<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';


$data=json_decode(file_get_contents("php://input"));




$id=mysqli_real_escape_string($con, $data->branch);
$date1 = mysqli_real_escape_string($con, $data->date1);
$date2 =mysqli_real_escape_string($con, $data->date2);


    $query="SELECT  stock.sid,product.pname ,stock.productid,brand.bname,company.cname,stock.remain,stock.stocktype,stock.costprice,stock.lotno,stock.receiveday,stock.expireday 
    FROM stock,product,company,brand 
    WHERE (stock.productid = product.regno AND stock.cid = company.cid AND product.brandid = brand.bid)
    AND stock.receiveday >= DATE('".$date1."')  AND stock.receiveday <= DATE('".$date2."')
    AND stock.subbranchid = ".$id."
    ORDER BY stock.receiveday DESC";
    $result = mysqli_query($con,$query);    


    $res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array( 'sid' =>$rows['sid'],'pname' =>$rows['pname'],'productid' =>$rows['productid'],'bname' =>$rows['bname'],'cname' =>$rows['cname'],'remain' =>$rows['remain']
    ,'stocktype' =>$rows['stocktype'],'costprice' =>$rows['costprice'],'lotno' =>$rows['lotno'],'receiveday' =>$rows['receiveday'],'expireday' =>$rows['expireday'] );
}
$stocks['records'] = $res;
echo json_encode($stocks);