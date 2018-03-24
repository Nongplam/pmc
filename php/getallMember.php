<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$output="";
$masterid=$_SESSION["masterbranchid"];

$query="select member.*,subbranch.mid from member,masterbranch,subbranch where member.subbranchid = subbranch.id and subbranch.mid = '$masterid' GROUP BY member.citizenid";
$result=mysqli_query($con, $query);
if(mysqli_num_rows($result)>0) {
    while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        if($output !="") {
            $output .=",";
        }
        $output .='{"citizenid":"' . $rs["citizenid"] . '",';
        $output .='"fname":"' . $rs["fname"] . '",';
        $output .='"lname":"' . $rs["lname"] . '",';
        $output .='"phonenumber":"' . $rs["phonenumber"] . '",';  
        $output .='"expdate":"' . $rs["expdate"] . '",'; 
        $output .='"point":"' . $rs["point"] . '",'; 
        $output .='"level":"' . $rs["level"] . '",';              
        $output .='"status":"' . $rs["status"] . '"}';
    }
    $output = '{"records":['.$output.']}';
    echo($output);
}

?>
