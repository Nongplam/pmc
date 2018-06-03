<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION["id"];
$subbranchid = $_SESSION["subbranchid"];

if($data){   
    $mgrkey = mysqli_real_escape_string($con, $data->mgrkey);
    
    $password=$mgrkey;    
    $query="SELECT user.id as id FROM user WHERE user.password = '$password' AND user.subbranchid = '$subbranchid' AND user.role = 'manager'";
    $result = mysqli_query($con,$query);
    
    $mgrid=array();
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($mgrid,$rows['id']);
    }
    if(!empty($mgrid[0])){
        $_SESSION["provemgrid"] = $mgrid[0];
    }else{
        echo "Wrong";
    }
    
}

?>
