<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$masterbranchid=$_SESSION["masterbranchid"];

$mainbranchidquery = "SELECT subbranch.id FROM subbranch WHERE subbranch.mid = '$masterbranchid' AND subbranch.ismainbranch = '1'";
    $mainbranchidresult = mysqli_query($con, $mainbranchidquery);
    $mainbranchidrows = mysqli_fetch_assoc($mainbranchidresult);
    $mainbranchid = $mainbranchidrows['id'];

$alluserinmainbranchquery="SELECT user.id,user.fname,user.lname,rolesetting.rolethai FROM user,rolesetting WHERE user.subbranchid = '$mainbranchid' AND rolesetting.rolename = user.role AND user.role != 'admin' AND user.role != 'owner'";

if($result = mysqli_query($con,$alluserinmainbranchquery)){

    while ($row = $result -> fetch_array(1)){

        $res[] =  $row ;

    }
    $alluserinmainbranch['records']= $res;
    echo   json_encode($alluserinmainbranch);
}else{
    echo mysqli_error($con);
}

?>
