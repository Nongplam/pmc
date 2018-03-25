<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


if($data){    
    $fname=mysqli_real_escape_string($con, $data->fname);
    $lname=mysqli_real_escape_string($con, $data->lname);
    $role=mysqli_real_escape_string($con, $data->role);
    $roledesc=mysqli_real_escape_string($con, $data->roledesc);
    $subbranch=mysqli_real_escape_string($con, $data->subbranch);
    $username=mysqli_real_escape_string($con, $data->username);
    $password=mysqli_real_escape_string($con, $data->password);
    $info=mysqli_real_escape_string($con, $data->info);
      
    
    if($role == 'admin' || $role == 'mainstoragemanager' || $role == 'owner'){
        $stm1="insert into user(fname,lname,role,roledesc,username,password,userinfo) values('$fname','$lname','$role','$roledesc','$username','$password','$info')";
    if(mysqli_query($con, $stm1)) {
        echo "Data Inserted";
        
        }
        else {
            echo "Error";
        }
    }else{
        $stm2="insert into user(fname,lname,role,roledesc,subbranchid,username,password,userinfo) values('$fname','$lname','$role','$roledesc','$subbranch','$username','$password','$info')";
    if(mysqli_query($con, $stm2)) {
        echo "Data Inserted";
        
        }
        else {
            echo "Error";
        }
    }
    
    
    
    
}


?>
