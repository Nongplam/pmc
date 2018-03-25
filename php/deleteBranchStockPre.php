<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

if($data) {


        $id = mysqli_real_escape_string($con,$data->bSP_id);

        $sql = "DELETE FROM branchstockprepare WHERE bSP_id = ".$id;

        if(mysqli_query($con,$sql)){
            echo "delete success";
        }else{
            echo "delete failed";
        }

}