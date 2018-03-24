<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$output="";
$subbranch = $_SESSION["subbranchid"];

$query="SELECT stock.*,product.pname,brand.bname,shelf.* FROM stock,shelf,product,brand WHERE stock.productid = product.regno and product.brandid = brand.bid and stock.subbranchid = shelf.subbranchid and shelf.stockid = stock.sid and stock.subbranchid = '$subbranch'";
$result=mysqli_query($con, $query);
if(mysqli_num_rows($result)>0) {
    while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        if($output !="") {
            $output .=",";
        }
        $output .='{"sid":"' . $rs["sid"] . '",';
        $output .='"productid":"' . $rs["productid"] . '",';
        $output .='"cid":"' . $rs["cid"] . '",';
        $output .='"remain":"' . $rs["shelfremain"] . '",';  
        $output .='"lotno":"' . $rs["lotno"] . '",'; 
        $output .='"stocktype":"' . $rs["stocktype"] . '",'; 
        $output .='"costprice":"' . $rs["costprice"] . '",';
        $output .='"baseprice":"' . $rs["baseprice"] . '",'; 
        $output .='"boxprice":"' . $rs["boxprice"] . '",'; 
        $output .='"retailprice":"' . $rs["retailprice"] . '",'; 
        $output .='"wholesaleprice":"' . $rs["wholesaleprice"] . '",'; 
        $output .='"receiveday":"' . $rs["receiveday"] . '",'; 
        $output .='"expireday":"' . $rs["expireday"] . '",'; 
        $output .='"pname":"' . $rs["pname"] . '",'; 
        $output .='"bname":"' . $rs["bname"] . '",'; 
        $output .='"shelfid":"' . $rs["shelfid"] . '"}';
    }
    $output = '{"records":['.$output.']}';
    echo($output);
}

?>
