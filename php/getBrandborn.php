<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

/*$data=json_decode(file_get_contents("php://input"));
$brandid=$data->brandid;
$output="";*/

$query="select * from brand";
$result = mysqli_query($con,$query);
$res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('bid' =>$rows['bid'] , 'bname' => $rows['bname'],'bcon'=>$rows['bcontact'],'btel'=>$rows['btel']);
}
$brand['records'] = $res;
echo json_encode($brand);

//echo $rows["bname"];
