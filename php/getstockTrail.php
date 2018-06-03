<?php
date_default_timezone_set("Asia/Bangkok");
header('Content-Type: text/html; charset=utf-8');
session_start();
include 'connectDB.php';

    /*$branchid =  $_GET["branch"];
    $date1 = $_GET["date1"];
    $date2 = $_GET["date2"];*/

    $stockid =  $_GET["trailid"];
    

    /*echo $branchid;
    echo $date1;
    echo $date2;*/

    $importhistoryquery="SELECT stock.sid,product.pname,stock.remainfull,stock.remain,stock.stocktype,stock.retailprice,stock.userid,user.fname,user.lname,stock.subbranchid,subbranch.name as branchname,stock.receiveday,stock.logdatetime FROM stock,product,user,subbranch WHERE product.regno = stock.productid AND user.id = stock.userid AND subbranch.id = stock.subbranchid AND stock.fromstockid = $stockid";
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
