<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {
    $branchid= mysqli_real_escape_string($con, $data->branch);    
    
    $sql="DELETE FROM prePromotion WHERE tobranch = '$branchid'";
    
        if(mysqli_query($con, $sql)) {
        echo "Data Deleted";        
        }
        else {
            echo "Error";
        } 
    /*$res = array();
    
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $prePromotion['records']= $res;
        echo   json_encode($prePromotion);
    }*/
}


?>
