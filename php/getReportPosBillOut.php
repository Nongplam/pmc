<?php
date_default_timezone_set("Asia/Bangkok");
header('Content-Type: text/html; charset=utf-8');
session_start();
include 'connectDB.php';





    $id =  $_GET["branch"];
    $date1 =$_GET["date"];
//echo $date1."\n";
        $sql = "SELECT dailysalemaster.billno,dailysalemaster.memberid,dailysalemaster.sumprice,dailysalemaster.masterdate FROM dailysalemaster WHERE dailysalemaster.subbranchid = $id AND DATE(dailysalemaster.masterdate) = DATE('$date1');";
            //echo $sql;
            if($result=  mysqli_query($con,$sql)){
                $res = array();
                while ($row = $result->fetch_array(1)){


                    $res[] = $row;
                }
                $bills['records'] = $res;
                echo json_encode($bills);



            }



