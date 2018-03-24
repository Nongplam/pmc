<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


if($data){    
    $id=mysqli_real_escape_string($con, $data->id);
    $fname=mysqli_real_escape_string($con, $data->fname);
    $lname=mysqli_real_escape_string($con, $data->lname);
    $role=mysqli_real_escape_string($con, $data->role);
    $roledesc=mysqli_real_escape_string($con, $data->roledesc);
    $subbranch=mysqli_real_escape_string($con, $data->subbranch);
    $username=mysqli_real_escape_string($con, $data->username);
    $password=mysqli_real_escape_string($con, $data->password);
    $userinfo=mysqli_real_escape_string($con, $data->info);
        
    if($role == 'admin' || $role == 'mainstoragemanager'){
        $query="update user set fname='$fname',lname='$lname',role='$role',roledesc='$roledesc',username='$username',password='$password',userinfo='$userinfo' where id='$id'";
    
    if(mysqli_query($con, $query)) {
            echo "Data Updated";            
        }
        else {
            echo "Error";
        }
    }else{
        $query2="update user set fname='$fname',lname='$lname',role='$role',roledesc='$roledesc',subbranchid='$subbranch',username='$username',password='$password',userinfo='$userinfo' where id='$id'";
    
    if(mysqli_query($con, $query2)) {
            echo "Data Updated";            
        }
        else {
            echo "Error";
        }
    }
    
}


?>
