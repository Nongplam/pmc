<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


if($data) {
        $prePO_id = mysqli_real_escape_string($con,$data->id);

        $sql = "DELETE FROM prePo WHERE prePo_id = $prePO_id";
        if(mysqli_query($con,$sql)){
            echo "{'del':'Successed'}";
        }else{
            echo "{'delErroe':'".mysqli_error($con)."'}";
        }



}