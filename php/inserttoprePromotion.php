<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {
    $stockid= mysqli_real_escape_string($con, $data->stock);    
    $targetbranchid= mysqli_real_escape_string($con, $data->branch); 
    $searchdupquery="SELECT * FROM prePromotion WHERE prePromotion.stockid = '$stockid' AND prePromotion.tobranch = '$targetbranchid'";
    $searchdupresult = mysqli_query($con, $searchdupquery);
    $searchduprows = mysqli_fetch_assoc($searchdupresult);
    
    $preid = $searchduprows['id'];
    $preqty = $searchduprows['qty'];
    $preqty = $preqty + 1;
    if(!empty($preid)){
        $updatequery="UPDATE prePromotion SET qty = '$preqty' WHERE prePromotion.id = '$preid'";
        if(mysqli_query($con, $updatequery)) {
        echo "Data Updated";        
        }
        else {
            echo "Error";
        }        
    }else{
        $insertquery="INSERT INTO prePromotion (stockid,tobranch,qty) VALUES ('$stockid','$targetbranchid','1')";
        if(mysqli_query($con, $insertquery)) {
        echo "Data Inserted";        
        }
        else {
            echo "Error";
        }
    }
    
    
    /*$sql="SELECT stock.sid,product.pname,stock.remainfull,stock.remain,stock.costprice,stock.retailprice,stock.expireday FROM stock,product WHERE product.regno=stock.productid AND stock.subbranchid = $branchid AND stock.ispromotion = 0";
    $res = array();
    
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $stockinbranch['records']= $res;
        echo   json_encode($stockinbranch);
    }*/
}


?>
