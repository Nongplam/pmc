<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$output="";
$subbranchid = $_SESSION["subbranchid"];
$userid = $_SESSION["id"];
$stm1="SELECT dmid
FROM dailysalemaster 
WHERE dailysalemaster.dmid = (SELECT MAX(dailysalemaster.dmid) FROM dailysalemaster where dailysalemaster.subbranchid = '$subbranchid' and dailysalemaster.userid = '$userid')";
$result = mysqli_query($con,$stm1);    
$dmid = $result->fetch_array(MYSQLI_ASSOC);
$dmidtemp = $dmid['dmid'];
    
$query="select dailysaledetail.*,product.pname,dailysalemaster.moneyreceive,dailysalemaster.moneychange,dailysalemaster.refkey,dailysalemaster.billno,subbranch.tel,subbranch.taxid from dailysaledetail,product,stock,dailysalemaster,subbranch where dailysaledetail.stockid=stock.sid AND stock.productid=product.regno AND dailysaledetail.masterid=dailysalemaster.dmid AND dailysaledetail.subbranchid = subbranch.id AND masterid='$dmidtemp'";
$result=mysqli_query($con, $query);
if(mysqli_num_rows($result)>0) {
        
    $res = array();
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('stockid' => $rows['stockid'],'qty'=>$rows['qty'],
                  'price'=>$rows['price'],'masterid'=>$rows['masterid'],'date'=>$rows['date'],'subbranchid'=>$rows['subbranchid'],'pname'=>$rows['pname'],'moneyreceive'=>$rows['moneyreceive'],'moneychange'=>$rows['moneychange'],'refkey'=>$rows['refkey'],'billno'=>$rows['billno'],'tel'=>$rows['tel'],'taxid'=>$rows['taxid']);
    }
    $billitem['records'] = $res;
    echo json_encode($billitem);
}

?>
