<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/2/2018
 * Time: 4:56 PM
 */
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

session_start();
$subbranchid = $_SESSION["subbranchid"];
$pname = mysqli_real_escape_string($con, $data->pname);
$type = mysqli_real_escape_string($con, $data->type);

$sql = "(SELECT dailysalemaster.masterdate AS date ,stock.PO_No,stock.lotno,dailysalemaster.billno AS billno,stock.expireday,dailysaledetail.price AS price ,stock.costprice,concat('-', dailysaledetail.qty )AS qty ,stock.stocktype 
FROM dailysalemaster,dailysaledetail,stock,product 
WHERE dailysalemaster.dmid = dailysaledetail.masterid 
AND dailysaledetail.stockid = stock.sid 
AND stock.productid = product.regno 
AND product.pname LIKE '%$pname%' 
AND stock.stocktype LIKE '%$type%'
AND dailysalemaster.subbranchid = $subbranchid)
 UNION (SELECT stock.receiveday AS date,stock.PO_No,stock.lotno,null AS billno,stock.expireday,stock.baseprice AS price ,stock.costprice, concat('+', stock.remainfull) AS qty,stock.stocktype 
 FROM stock,product 
 WHERE product.pname LIKE '%$pname%' 
 AND stock.stocktype LIKE '%$type%'
 AND stock.subbranchid = $subbranchid) 
 ORDER BY date";



$result = mysqli_query($con,$sql);
$res = array();
$ba = 0;
while ($rows = $result->fetch_array(1)){

                $qty = $rows['qty'];
    $ba = $ba + $qty;
    $res[] = array('date' =>$rows['date'],'PO_No' =>$rows['PO_No'],'lotno' =>$rows['lotno'],'billno' =>$rows['billno'],'expireday' =>$rows['expireday'],'price' =>$rows['price'],'costprice' =>$rows['costprice'],'qty' =>$rows['qty'] ,'balanch' =>$ba);
}
$brand['records'] = $res;
echo json_encode($brand);



