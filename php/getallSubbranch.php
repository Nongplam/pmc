<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$masterbranchid=$_SESSION["masterbranchid"];
$output="";

$query="select * from subbranch where subbranch.mid = '$masterbranchid'";
$result=mysqli_query($con, $query);
if(mysqli_num_rows($result)>0) {
    while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        if($output !="") {
            $output .=",";
        }
        $output .='{"id":"' . $rs["id"] . '",';
        $output .='"mid":"' . $rs["mid"] . '",';        
        $output .='"name":"' . $rs["name"] . '",'; 
        $output .='"info":"' . $rs["info"] . '",';
        $output .='"tel":"' . $rs["tel"] . '"}';
    }
    $output = '{"records":['.$output.']}';
    echo($output);
}

?>
