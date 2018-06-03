<?php
	include 'connectDB.php';
	
    $maxbillnoquery="SELECT MAX(billno) as billno FROM dailysalemaster WHERE dailysalemaster.subbranchid = 2;";
    $maxbillnoresult = mysqli_query($con, $maxbillnoquery);
    $maxbillnorows = mysqli_fetch_assoc($maxbillnoresult);
if($maxbillnorows['billno'] == NULL){
    echo "null";
}
    echo $maxbillnorows['billno'];
    //newbillid = sprintf("%010d", $maxbillnorows['billno']+1);

?>
