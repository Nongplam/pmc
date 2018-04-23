<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subbranchid = $_SESSION["subbranchid"];

if($data){
    /*$fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $citizenid = $_POST['citizenid'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];*/
    
    $fname=mysqli_real_escape_string($con, $data->fname);
    $lname=mysqli_real_escape_string($con, $data->lname);
    $citizenid=mysqli_real_escape_string($con, $data->citizenid);
    $phone=mysqli_real_escape_string($con, $data->phone);
    $gender=mysqli_real_escape_string($con, $data->gender);
    $birthday=mysqli_real_escape_string($con, $data->birthday);
    
    //echo $birthday;
    $date=date_create($birthday);
    $birthday = date_format($date,"Y-m-d");
    //echo $birthday;
    
    $stm1="insert into member(citizenid,fname,lname,phonenumber,gender,birthday,subbranchid) values('$citizenid','$fname','$lname','$phone','$gender','$birthday','$subbranchid')";
    if(mysqli_query($con, $stm1)) {
            echo "Member Inserted";
            /*echo $fname;
            echo $lname;
            echo $citizenid;
            echo $phone;
            echo $gender;
            echo $birthday;*/
        }
        else {
            echo "Error";
        }
    
}


?>
