<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

if($data) {
    //Query เมื่อข้อมูลเปลี่ยนแปลง
    $regno=mysqli_real_escape_string($con, $data->regno);
    $realregno=mysqli_real_escape_string($con, $data->realregno);
    $pname=mysqli_real_escape_string($con, $data->pname);
    $pcore=mysqli_real_escape_string($con, $data->pcore);
    $pdesc=mysqli_real_escape_string($con, $data->pdesc);
    $brandid=mysqli_real_escape_string($con, $data->brandid);
    $btnName=$data->btnName; //สถานะปุ่ม
    if ($btnName=="Insert") {
        $query="insert into product(realregno,pname,pcore,pdesc,brandid) values('$realregno','$pname','$pcore','$pdesc','$brandid')";
        if(mysqli_query($con, $query)) {
            echo "Data Inserted";
        }
        else {
            echo "Error";
        }
    }
    if ($btnName=="Update") {
        $query="update product set realregno='$realregno', pname='$pname',pcore='$pcore',pdesc='$pdesc' ,brandid ='$brandid' where regno='$regno'";
        if(mysqli_query($con, $query)) {
            echo "Data Updated";
        }
        else {
            echo "Error";
        }
    }
}

?>
