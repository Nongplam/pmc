<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subbranchid = $_SESSION["subbranchid"];

if(!empty($_POST["fname"])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $citizenid = $_POST['citizenid'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    
    $stm1="insert into member(citizenid,fname,lname,phonenumber,gender,birthday,subbranchid) values('$citizenid','$fname','$lname','$phone','$gender','$birthday','$subbranchid')";
    if(mysqli_query($con, $stm1)) {
            echo "Data Inserted";
            echo $fname;
            echo $lname;
            echo $citizenid;
            echo $phone;
            echo $gender;
            echo $birthday;
        }
        else {
            echo "Error";
        }
    
}


?>
