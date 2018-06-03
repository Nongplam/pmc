<?php
date_default_timezone_set("Asia/Bangkok");
header('Content-Type: text/html; charset=utf-8');
session_start();
include 'connectDB.php';
$masterbramchid = $_SESSION["masterbranchid"];


$branchid = $_GET["branch"];
$barcode = $_GET["barcode"];

if($branchid == 'undefined'){
    $findproductquery="SELECT shelf.shelfno,shelf.shelfinfo,shelf.shelfremain,subbranch.name as branchname,stock.sid,product.pname,stock.stocktype FROM shelf,stock,product,subbranch WHERE shelf.stockid = stock.sid AND product.regno = stock.productid AND subbranch.id = shelf.subbranchid AND stock.barcode = $barcode AND subbranch.mid = $masterbramchid";
}else{
    $findproductquery="SELECT shelf.shelfno,shelf.shelfinfo,shelf.shelfremain,subbranch.name as branchname,stock.sid,product.pname,stock.stocktype FROM shelf,stock,product,subbranch WHERE shelf.stockid = stock.sid AND product.regno = stock.productid AND subbranch.id = shelf.subbranchid AND stock.barcode = $barcode AND shelf.subbranchid = $branchid AND subbranch.mid = $masterbramchid";
}


    
  if($result=  mysqli_query($con,$findproductquery)){
                $res = array();
                while ($row = $result->fetch_array(1)){


                    $res[] = $row;
                }
                $product['records'] = $res;
                echo json_encode($product);



            }
    
    
    
?>
