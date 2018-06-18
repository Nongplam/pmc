<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/14/2018
 * Time: 3:23 PM
 */

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$subid= $_SESSION['subbranchid'];

$query="select * from subbranch where subbranch.id = $subid";
if($result = mysqli_query($con,$query)){
    $res = array();
    while ($row = $result -> fetch_array(1)){

        $res[] =  $row ;

    }
    $branch['records']= $res;
    echo   json_encode($branch);
}else{
    echo mysqli_error($branch);
}