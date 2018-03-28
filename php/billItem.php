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
    
$query="select * from dailysaledetail where masterid='$dmidtemp'";
$result=mysqli_query($con, $query);
if(mysqli_num_rows($result)>0) {
    while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        if($output !="") {
            $output .=",";
        }
        $output .='{"stockid":"' . $rs["stockid"] . '",';
        $output .='"qty":"' . $rs["qty"] . '",';
        $output .='"price":"' . $rs["price"] . '",';
        $output .='"masterid":"' . $rs["masterid"] . '",';
        $output .='"date":"' . $rs["date"] . '",';
        $output .='"subbranchid":"' . $rs["subbranchid"] . '"}';        
    }
    $output = '{"records":['.$output.']}';
    echo($output);
}

?>
