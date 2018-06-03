<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/3/2018
 * Time: 6:22 PM
 */


session_start();
header('Content-Type: text/html; charset=utf-8');
include "connectDB.php";

$subid= $_SESSION['subbranchid'];



$sql = "SELECT product.pname ,stock.sid,stock.PO_No,stock.lotno,brand.bname,company.cname,stock.remainfull,stock.remain,stock.stocktype,stock.costprice,stock.baseprice,stock.receiveday,stock.expireday,stock.subbranchid FROM stock,company,product LEFT JOIN brand ON product.brandid = brand.bid WHERE stock.productid = product.regno AND stock.cid = company.cid AND stock.subbranchid = $subid";




$result = mysqli_query($con,$sql);

$res = array();


while ($row = $result -> fetch_array(1)){

    $res[] = $row;
}

$stocks['records']= $res;
echo   json_encode($stocks);