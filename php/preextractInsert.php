<?php
/**
 * Created by PhpStorm.
 * User: MRoSlot
 * Date: 3/22/2018
 * Time: 11:25 PM
 */
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subbranchid=$_SESSION["subbranchid"];
$userid=$_SESSION["id"];
print_r($_SESSION);

if($data){
    $stockid=mysqli_real_escape_string($con, $data->stockid);
    $newtype=mysqli_real_escape_string($con, $data->newtype);
    $newqty=mysqli_real_escape_string($con, $data->newqty);
    $stm1="SELECT * FROM stock WHERE stock.sid = '$stockid'";
    $stm1result=mysqli_query($con, $stm1);
    $res = array();
while ($rows = $stm1result->fetch_array(MYSQLI_ASSOC)){    
    $res[] = array('sid' =>$rows['sid'] , 'remain' => $rows['remain'],'stocktype'=>$rows['stocktype']);
}
    echo = $stockid;
    echo = $newtype;
    echo = $newqty;
    print_r($res);
    
    $stm2="INSERT INTO extractPrepare (cname, contact,masterbranchid) VALUE ('$cname','$ccon','$masterbranchid')";
    
        
        /*if(mysqli_query($con, $stm1)) {
             echo "Data Inserted"; 
        }
        else {
            echo "Insert Error";
        }       */ 
    
}
?>
