<?php

header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));




$id=mysqli_real_escape_string($con, $data->branch);
$date1 = mysqli_real_escape_string($con, $data->date1);
$date2 =mysqli_real_escape_string($con, $data->date2);

    $query="SELECt stock.sid,product.pname,stock.productid,brand.bname,SUM(dailysaledetail.qty) as qty,
    SUM(dailysaledetail.price * dailysaledetail.qty) as sell,SUM( dailysaledetail.qty * stock.costprice) as cost,
    SUM( (dailysaledetail.price - stock.costprice)* dailysaledetail.qty) as profit,stock.lotno ,stock.receiveday 
    FROM dailysaledetail ,stock,product,brand 
    WHERE dailysaledetail.stockid = stock.sid AND stock.productid = product.regno AND product.brandid = brand.bid  
    AND (dailysaledetail.date >= DATE('".$date1."') AND dailysaledetail.date <= DATE('".$date2."') ) 
    AND dailysaledetail.subbranchid = ".$id." GROUP BY dailysaledetail.stockid ORDER BY profit DESC";


 
    $result = mysqli_query($con,$query);    

       
    $res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('sid' =>$rows['sid'],'pname' =>$rows['pname'],'productid' =>$rows['productid'],'bname' =>$rows['bname'],'qty' =>$rows['qty']
    ,'sell' =>$rows['sell'],'cost' =>$rows['cost'],'profit' =>$rows['profit'],'lotno' =>$rows['lotno'],
    'receiveday' =>$rows['receiveday'] );
}
$stocks['records'] = $res;
echo json_encode($stocks);