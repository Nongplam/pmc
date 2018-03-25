<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$mid = 1/*$_SESSION["masterbranchid"]*/;

$query="select * from subbranch WHERE mid = $mid";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('id' =>$rows['id'],'mid' =>$rows['mid'],'name' =>$rows['name'],'info' =>$rows['info'],'tel' =>$rows['tel'] );
}
$subbranch['records'] = $res;
echo json_encode($subbranch);