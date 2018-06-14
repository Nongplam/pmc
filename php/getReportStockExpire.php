<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$id=$_GET['branch'];
$type = $_GET['type'];

$query = "SELECT * FROM (SELECT stock.sid AS sid,product.pname,stock.stocktype,stock.lotno,(stock.remain+IF((SELECT SUM(shelf.shelfremain) FROM shelf WHERE shelf.stockid = sid GROUP BY shelf.stockid) IS NULL, 0, (SELECT SUM(shelf.shelfremain) FROM shelf WHERE shelf.stockid = sid GROUP BY shelf.stockid))) AS sumremain,stock.costprice,stock.expireday,DATEDIFF(stock.expireday, NOW()) AS DateDiff FROM stock,product,shelf WHERE product.regno = stock.productid AND stock.subbranchid ='$id' GROUP BY stock.sid)AS stockexp WHERE stockexp.sumremain > 0";



    $result = mysqli_query($con,$query);    


    $res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = $rows;
}
$stocks['records'] = $res;
echo json_encode($stocks);
