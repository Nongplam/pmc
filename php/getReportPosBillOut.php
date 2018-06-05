<?php
date_default_timezone_set("Asia/Bangkok");
header('Content-Type: text/html; charset=utf-8');
session_start();
include 'connectDB.php';





    $id =  $_GET["branch"];
    $date1 =$_GET["date"];
    $date2 =$_GET["date2"];
//echo $date1."\n";

    if($id == "allbranch"){
        $sql = "SELECT dailysalemaster.billno,dailysalemaster.memberid,dailysalemaster.sumprice, dailysalemaster.masterdate,subbranch.name as branchname,dailysaledetail.stockid,dailysaledetail.qty,dailysaledetail.price,stock.costprice,SUM((dailysaledetail.price-stock.costprice)*dailysaledetail.qty) as profit FROM dailysalemaster,dailysaledetail,stock,subbranch WHERE subbranch.id = dailysalemaster.subbranchid AND stock.sid = dailysaledetail.stockid AND dailysaledetail.masterid = dailysalemaster.dmid AND DATE(dailysalemaster.masterdate) >= DATE('$date1') AND DATE(dailysalemaster.masterdate) <= DATE('$date2') GROUP BY dailysalemaster.dmid";
            //echo $sql;
            if($result=  mysqli_query($con,$sql)){
                $res = array();
                while ($row = $result->fetch_array(1)){
                    $res[] = $row;
                }
                $bills['records'] = $res;
                echo json_encode($bills);
            }
    }else{
        $sql = "SELECT dailysalemaster.billno,dailysalemaster.memberid,dailysalemaster.sumprice, dailysalemaster.masterdate,subbranch.name as branchname,dailysaledetail.stockid,dailysaledetail.qty,dailysaledetail.price,stock.costprice,SUM((dailysaledetail.price-stock.costprice)*dailysaledetail.qty) as profit FROM dailysalemaster,dailysaledetail,stock,subbranch WHERE subbranch.id = dailysalemaster.subbranchid AND stock.sid = dailysaledetail.stockid AND dailysaledetail.masterid = dailysalemaster.dmid AND dailysalemaster.subbranchid = '$id' AND DATE(dailysalemaster.masterdate) >= DATE('$date1') AND DATE(dailysalemaster.masterdate) <= DATE('$date2') GROUP BY dailysalemaster.dmid";
            //echo $sql;
            if($result=  mysqli_query($con,$sql)){
                $res = array();
                while ($row = $result->fetch_array(1)){
                    $res[] = $row;
                }
                $bills['records'] = $res;
                echo json_encode($bills);
            }
    }
