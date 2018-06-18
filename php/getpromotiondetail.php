<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

if($data){
      
    $res = array();
    $rec = array();
    $detail = mysqli_real_escape_string($con, $data->detail);
    $temparr = explode(",",$detail);
    //print_r($temparr);
    for($i = 0;$i<count($temparr);$i++){
        $tempsid = explode("=",$temparr[$i]);
        $pnamequery="SELECT product.pname,stock.stocktype FROM stock,product WHERE product.regno = stock.productid AND stock.sid = $tempsid[0]";
        $pnameresult = mysqli_query($con, $pnamequery);
        $pnamerows = mysqli_fetch_assoc($pnameresult);    
        $panme = $pnamerows['pname'];
        $type = $pnamerows['stocktype'];
        $res['pname'] = $panme;
        $res['type'] = $type;
        $res['qty'] = $tempsid[1];
        //echo $panme;
        //print_r($tempsid);
        //echo $temparr[$i];
        
        $rec['records'][] = $res;
        //echo "\n";
    }
    echo json_encode($rec); 
}else{
    echo "Error";
}
