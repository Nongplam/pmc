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
$masterbranchid=$_SESSION["masterbranchid"];

if($data){
    $cname=mysqli_real_escape_string($con, $data->cname);
    $ccon=mysqli_real_escape_string($con, $data->ccon);
    $btnName=mysqli_real_escape_string($con, $data->btnName);
    if($btnName == "Insert"){
        $stm1="INSERT INTO company (cname, contact,masterbranchid) VALUE ('$cname','$ccon','$masterbranchid')";
        if(mysqli_query($con, $stm1)) {
             echo "Data Inserted"; 
        }
        else {
            echo "Insert Error";
        }
        
    }elseif ($btnName == "Update"){
        $cid=mysqli_real_escape_string($con, $data->cid);
        $stm2="UPDATE company SET cname='$cname',contact='$ccon' WHERE cid = '$cid'";
        if(mysqli_query($con, $stm2)) {
            echo "Data Updated";
        }
        else {
            echo "Insert Error";
        }
    }
}
?>
