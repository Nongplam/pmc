<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));


if($data){    
    $id=mysqli_real_escape_string($con, $data->id);
    $name=mysqli_real_escape_string($con, $data->name);
    $tel=mysqli_real_escape_string($con, $data->tel);
    $info=mysqli_real_escape_string($con, $data->info);
    $taxid=mysqli_real_escape_string($con, $data->taxid);
    $branchtype=mysqli_real_escape_string($con, $data->branchtype);
        
    $query="update subbranch set name='$name',tel='$tel',info='$info',taxid='$taxid',branchtype='$branchtype' where id='$id'";
    
    if(mysqli_query($con, $query)) {
            echo "Data Updated";            
        }
        else {
            echo "Error";
        }
}


?>
