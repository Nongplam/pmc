<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
if($data){
    $datestart=mysqli_real_escape_string($con, $data->datestart);
    $dateend=mysqli_real_escape_string($con, $data->dateend);    
    $subbranchid=mysqli_real_escape_string($con, $data->branch);  
    $res = array();
$query="SELECT product.pname,product.regno,stock.stocktype,SUM(dailysaledetail.qty) AS qty,SUM(stock.costprice*dailysaledetail.qty) AS costperlist,SUM(dailysaledetail.price*dailysaledetail.qty) AS priceperlist,SUM((dailysaledetail.price-stock.costprice)*dailysaledetail.qty) AS profitperlist FROM dailysaledetail,stock,product WHERE product.regno = stock.productid AND stock.sid = dailysaledetail.stockid AND dailysaledetail.subbranchid = '$subbranchid' AND dailysaledetail.date >= '$datestart 00:00:00' AND dailysaledetail.date <= '$dateend 23:59:59' GROUP BY product.pname,product.regno,stock.stocktype";
if($result = mysqli_query($con,$query)){

    while ($row = $result -> fetch_array(1)){

        $res[] =  $row ;

    }
    $alluserinmainbranch['records']= $res;
    echo   json_encode($alluserinmainbranch);
}else{
    echo mysqli_error($con);
}
}

/**/
?>
