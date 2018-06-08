<?php
/*
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/2/2018
 * Time: 6:49 PM
 */

header('Content-Type: text/html; charset=utf-8');
include "connectDB.php";
session_start();



$subbranchid = $_SESSION["subbranchid"];

$sql = "SELECT product.pname,stock.stocktype FROM stock,product WHERE stock.productid = product.regno AND stock.subbranchid = $subbranchid GROUP BY product.pname,stock.stocktype";






$result = mysqli_query($con,$sql);
$res = array();
while($row = $result -> fetch_array(1) ){

    $res[] = array('pname'  =>$row['pname'],'type' => $row['stocktype'] ) ;

}

$brand['records'] = $res;
echo json_encode($brand);


