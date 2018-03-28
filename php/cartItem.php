<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
session_start();

$userid = $_SESSION["id"];
$subbranchid = $_SESSION["subbranchid"];

$output="";

$query="SELECT pos.*,product.pname,product.pcore,stock.stocktype FROM pos,stock,product WHERE pos.stockid = stock.sid AND stock.productid=product.regno AND pos.userid = '$userid'";
$result=mysqli_query($con, $query);
if(mysqli_num_rows($result)>0) {
    while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        if($output !="") {
            $output .=",";
        }
        $output .='{"id":"' . $rs["id"] . '",';
        $output .='"stockid":"' . $rs["stockid"] . '",';
        $output .='"price":"' . $rs["price"] . '",';
        $output .='"qty":"' . $rs["qty"] . '",';
        $output .='"pname":"' . $rs["pname"] . '",';
        $output .='"pcore":"' . $rs["pcore"] . '",';        
        $output .='"stocktype":"' . $rs["stocktype"] . '"}';        
    }
    $output = '{"records":['.$output.']}';
    echo($output);
}

?>
