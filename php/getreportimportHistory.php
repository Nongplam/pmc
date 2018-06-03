<?php
date_default_timezone_set("Asia/Bangkok");
header('Content-Type: text/html; charset=utf-8');
session_start();
include 'connectDB.php';

    /*$branchid =  $_GET["branch"];
    $date1 = $_GET["date1"];
    $date2 = $_GET["date2"];*/

    $branchid =  $_GET["branch"];
    $date1 = $_GET["date1"];
    $date2 = $_GET["date2"];

    /*echo $branchid;
    echo $date1;
    echo $date2;*/

    $importhistoryquery="SELECT stock.sid,product.pname,stock.PO_No,stock.lotno,stock.cid,company.cname,stock.costprice,stock.remainfull,stock.remain,stock.stocktype,stock.retailprice,stock.receiveday,stock.logdatetime FROM stock,product,company WHERE stock.receiveday >= '$date1' AND stock.receiveday <= '$date2' AND stock.subbranchid = '$branchid' AND product.regno = stock.productid AND company.cid = stock.cid";
//echo $importhistoryquery;

    if($result=  mysqli_query($con,$importhistoryquery)){
                $res = array();
                while ($row = $result->fetch_array(1)){


                    $res[] = $row;
                }
                $history['records'] = $res;
                echo json_encode($history);



            }




?>
