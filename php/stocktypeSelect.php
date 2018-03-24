<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';


$query="select stocktype from stock group by stocktype";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('stocktype' =>$rows['stocktype'] );
}
$stocktypes['records'] = $res;
echo json_encode($stocktypes);
