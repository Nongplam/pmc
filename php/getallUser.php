<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$masterbranchid=$_SESSION["masterbranchid"];
$output="";

//$query="SELECT user.*,subbranch.name FROM user,subbranch WHERE subbranch.id = user.subbranchid";
$query="SELECT user.id,user.fname,user.lname,user.role,rolesetting.rolethai as roledesc,user.userinfo,user.username,user.subbranchid,subbranch.name FROM user,subbranch,rolesetting WHERE user.role = rolesetting.rolename and subbranch.id = user.subbranchid and subbranch.mid = '$masterbranchid'";
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
        $output .='"name":"' . $rs["name"] . '"}';
    }
    $output = '{"records":['.$output.']}';
    echo($output);
}

?>
