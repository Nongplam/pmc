<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$masterbranchid=$_SESSION["masterbranchid"];

if($data){    
    $name=mysqli_real_escape_string($con, $data->name);
    $tel=mysqli_real_escape_string($con, $data->tel);    
    $info=mysqli_real_escape_string($con, $data->info);
    $taxid=mysqli_real_escape_string($con, $data->taxid);
    $branchtype=mysqli_real_escape_string($con, $data->branchtype);
        
    $stm1="insert into subbranch(mid,name,tel,info,taxid,branchtype) values('$masterbranchid','$name','$tel','$info','$taxid','$branchtype')";
    if(mysqli_query($con, $stm1)) {
            echo "Data Inserted";            
        }
        else {
            echo "Error";
        }
}


?>
