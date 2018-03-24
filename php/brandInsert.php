<?php

header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

if($data) {
    //Query เมื่อข้อมูลเปลี่ยนแปลง
    $bid=mysqli_real_escape_string($con, $data->bid);
    $bname=mysqli_real_escape_string($con, $data->bname);
    $bcon=mysqli_real_escape_string($con, $data->bcon);
    $btel=mysqli_real_escape_string($con, $data->btel);
   

    $btnName=$data->btnName; //สถานะปุ่ม
    if ($btnName=="Insert") {
        $query="insert into brand(bname,bcontact,btel) values('$bname','$bcon','$btel')";
        if(mysqli_query($con, $query)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }
    }
    if ($btnName=="Update") {
        
        $query="update brand set bname='$bname',bcontact='$bcon',btel='$btel'  where bid='$bid'";
        if(mysqli_query($con, $query)) {
            echo "Data Updated";
        }
        else {
            echo "Error update";
        }
    }
}



?>
