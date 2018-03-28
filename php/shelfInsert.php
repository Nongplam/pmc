<?php
/**
 * Created by PhpStorm.
 * User: MRoSlot
 * Date: 3/22/2018
 * Time: 11:25 PM
 */
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subbranchid=$_SESSION["subbranchid"];
$userid=$_SESSION["id"];
if($data){
    $shelfno=mysqli_real_escape_string($con, $data->shelfno);
    $shelfcode=mysqli_real_escape_string($con, $data->shelfcode);
    $shelfinfo=mysqli_real_escape_string($con, $data->shelfinfo);
    $btnName=mysqli_real_escape_string($con, $data->btnName);
    if($btnName == "Insert"){
        $stm1="INSERT INTO shelf (shelfno,shelfcode,shelfinfo,subbranchid,userid) VALUES('$shelfno','$shelfcode','$shelfinfo','$subbranchid','$userid')";
        if(mysqli_query($con, $stm1)) {
             echo "Data Inserted"; 
        }
        else {
            echo "Insert Error";
        }
        
    }else if ($btnName == "Update"){        
        $stm2="UPDATE shelf SET shelf.shelfcode = '$shelfcode', shelf.shelfinfo = '$shelfinfo' WHERE shelf.subbranchid = '$subbranchid' AND shelf.shelfno = '$shelfno'";
        if(mysqli_query($con, $stm2)) {
            echo "Data Updated";
        }
        else {
            echo "Update Error";
        }
    }
}
?>
