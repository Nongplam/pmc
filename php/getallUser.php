<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$output="";

$query="SELECT user.*,subbranch.name FROM user,subbranch WHERE subbranch.id = user.subbranchid";
$result=mysqli_query($con, $query);
if(mysqli_num_rows($result)>0) {
    while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        if($output !="") {
            $output .=",";
        }
        $output .='{"id":"' . $rs["id"] . '",';
        $output .='"fname":"' . $rs["fname"] . '",';        
        $output .='"lname":"' . $rs["lname"] . '",'; 
        $output .='"role":"' . $rs["role"] . '",'; 
        $output .='"roledesc":"' . $rs["roledesc"] . '",'; 
        $output .='"subbranchid":"' . $rs["subbranchid"] . '",'; 
        $output .='"userinfo":"' . $rs["userinfo"] . '",'; 
        $output .='"username":"' . $rs["username"] . '",'; 
        $output .='"password":"' . $rs["password"] . '",'; 
        $output .='"name":"' . $rs["name"] . '"}';
    }
    $output = '{"records":['.$output.']}';
    echo($output);
}

?>
