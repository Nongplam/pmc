<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$output="";
$subbranch = $_SESSION["subbranchid"];
$query="SELECT shelf.* FROM shelf WHERE shelf.subbranchid = '$subbranch' GROUP BY shelf.shelfno";

$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('shelfno' => $rows['shelfno'],'shelfcode'=>$rows['shelfcode'],
                  'shelfinfo'=>$rows['shelfinfo'],'subbranchid'=>$rows['subbranchid']);
}
$shelf['records'] = $res;
echo json_encode($shelf);

?>
