<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

if(!empty($_GET['refkey'])){
    $subbranch = $_SESSION["subbranchid"];
$refkey = $_GET['refkey'];


$dmidquery="SELECT * FROM dailysalemaster WHERE dailysalemaster.subbranchid = '$subbranch' AND dailysalemaster.refkey = '$refkey'";
$dmidresult = mysqli_query($con, $dmidquery);
$dmidrows = mysqli_fetch_assoc($dmidresult);
$dmid = $dmidrows['dmid'];

//echo $dmid;

$returnitemquery="SELECT dailysaledetail.*,product.pname FROM dailysaledetail,product,stock WHERE dailysaledetail.masterid = $dmid AND stock.sid = dailysaledetail.stockid AND product.regno = stock.productid AND dailysaledetail.subbranchid = '$subbranch'";

$result = mysqli_query($con,$returnitemquery);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('ddid' => $rows['ddid'],'masterid'=>$rows['masterid'],
                  'stockid'=>$rows['stockid'],'qty'=>$rows['qty'],'price'=>$rows['price'],'subbranchid'=>$rows['subbranchid'],'userid'=>$rows['userid'],'pname'=>$rows['pname']);
}
$returns['records'] = $res;
echo json_encode($returns);
}else{
    echo "error";
}


?>
