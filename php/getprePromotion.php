<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {
    $branchid= mysqli_real_escape_string($con, $data->branch);    
    $sql="SELECT prePromotion.stockid,product.pname,qty,stock.stocktype,subbranch.name FROM prePromotion,stock,product,subbranch WHERE product.regno = stock.productid AND stock.sid = prePromotion.stockid AND prePromotion.tobranch = '$branchid' AND subbranch.id = '$branchid'";
    $res = array();
    
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $prePromotion['records']= $res;
        echo   json_encode($prePromotion);
    }
}


?>
