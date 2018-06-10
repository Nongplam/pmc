<?php
session_start();
$subbranchid = $_SESSION["subbranchid"];
	include 'connectDB.php';
	
    $maxbillnoquery="SELECT MAX(billno) as billno FROM dailysalemaster WHERE dailysalemaster.subbranchid = '$subbranchid';";
    $maxbillnoresult = mysqli_query($con, $maxbillnoquery);
    $maxbillnorows = mysqli_fetch_assoc($maxbillnoresult);
if($maxbillnorows['billno'] == NULL){
    $newbillid = sprintf("%010d", 1);
    echo $newbillid;
}else{
    //echo $maxbillnorows['billno'];
    $newbillid = sprintf("%010d", $maxbillnorows['billno']+1);
    echo $newbillid;
}    

?>
