<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {
    $branchid= mysqli_real_escape_string($con, $data->branch);    
    $sql="SELECT stock.sid,product.pname,stock.remainfull,stock.remain,stock.stocktype,stock.costprice,stock.retailprice,stock.expireday,subbranch.name FROM stock,product,subbranch WHERE product.regno=stock.productid AND stock.remain > 0 AND stock.subbranchid = $branchid AND stock.ispromotion = 0 AND subbranch.id = '$branchid'";
    $res = array();
    
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $stockinbranch['records']= $res;
        echo   json_encode($stockinbranch);
    }
}


?>
