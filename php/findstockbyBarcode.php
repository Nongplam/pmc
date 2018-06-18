<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$subid = $_SESSION['subbranchid'];
$branchtype = $_SESSION["branchtype"];
$data=json_decode(file_get_contents("php://input"));

if($data){
    $barcode = mysqli_real_escape_string($con,$data->barcode);
    if($branchtype == 1){
    $query = "SELECT stock.sid,stock.remain,stock.lotno,stock.stocktype,stock.retailprice,product.pname FROM stock,product WHERE product.regno = stock.productid AND stock.subbranchid = '$subid' AND stock.barcode = '$barcode'";
    $res = array();
    if($result = mysqli_query($con,$query)){
        while ($row = $result -> fetch_array(1)){
            $res[] =  $row ;
        }
        $json['records'] = $res;
        $nagativecount = 0;
        for($i = 0;$i<count($res);$i++){
            if($res[$i]['remain'] < 1){
                $nagativecount++;
            }else{
                $json['records'] = $res[$i];
                break;
            }
        }        
        if($nagativecount == count($res)){
            echo json_encode($json['records'][count($res)-1]);
        }else{
            echo json_encode($json['records']);
        }
    }else{
        echo "Error";
    }
}else if($branchtype == 2){
    $query = "SELECT stock.sid,stock.remain,stock.lotno,stock.stocktype,stock.wholesaleprice AS retailprice,product.pname FROM stock,product WHERE product.regno = stock.productid AND stock.subbranchid = '$subid' AND stock.barcode = '$barcode'";
    $res = array();
    if($result = mysqli_query($con,$query)){
        while ($row = $result -> fetch_array(1)){
            $res[] =  $row ;
        }
        $json['records'] = $res;
        $nagativecount = 0;
        for($i = 0;$i<count($res);$i++){
            if($res[$i]['remain'] < 1){
                $nagativecount++;
            }else{
                $json['records'] = $res[$i];
                break;
            }
        }        
        if($nagativecount == count($res)){
            echo json_encode($json['records'][count($res)-1]);
        }else{
            echo json_encode($json['records']);
        }
    }else{
        echo "Error";
    }
}
}




?>
