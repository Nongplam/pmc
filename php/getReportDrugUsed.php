<?php 

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$masterbranchid=$_SESSION["masterbranchid"];

$mainbranchidquery = "SELECT subbranch.id FROM subbranch WHERE subbranch.mid = '$masterbranchid' AND subbranch.ismainbranch = '1'";
    $mainbranchidresult = mysqli_query($con, $mainbranchidquery);
    $mainbranchidrows = mysqli_fetch_assoc($mainbranchidresult);
    $mainbranchid = $mainbranchidrows['id'];

$allsubbranch = "SELECT subbranch.id FROM subbranch WHERE subbranch.mid = '$masterbranchid' AND subbranch.ismainbranch = '2'";

if($result = mysqli_query($con,$allsubbranch)){
    $res = array();
    while ($row = $result ->fetch_array(1) ){
        $res[]  = $row['id'];
    }
    $reportused =   $res;
    //print_r($reportused);
}else{
    echo mysqli_error($con);
}

//$reportused = array();
$res = array();
for($i = 0;$i<count($reportused);$i++){
    //echo $i;
    
    $branchid = $reportused[$i];
    $reportdrugused="SELECT T.*,T2.* FROM (SELECT stock.subbranchid,subbranch.name,stock.productid AS mainpid,product.pname AS pname ,stock.stocktype AS mainstocktype,(SELECT SUM(stock.remain) FROM stock WHERE stock.subbranchid = '$mainbranchid' AND stock.productid = mainpid AND stock.stocktype = mainstocktype) AS mainbranchremain,SUM(stock.remain) AS branchremain FROM stock,product,subbranch WHERE product.regno = stock.productid AND subbranch.id = stock.subbranchid AND stock.subbranchid = '$branchid' GROUP BY product.pname,stock.stocktype) T, (SELECT SUM(dailysaledetail.qty)/(SELECT DATEDIFF(MAX(dailysaledetail.date),MIN(dailysaledetail.date)) FROM dailysaledetail WHERE dailysaledetail.subbranchid = '$branchid') AS aveusedperday,product.pname AS pname,stock.stocktype AS stocktype FROM dailysaledetail,stock,product WHERE dailysaledetail.subbranchid = '$branchid' AND product.regno = stock.productid AND stock.sid = dailysaledetail.stockid GROUP BY product.pname,stock.stocktype) T2 WHERE T.pname = T2.pname AND T.mainstocktype = T2.stocktype";


if($result=  mysqli_query($con,$reportdrugused)){
                
                while ($row = $result->fetch_array(1)){
                    //array_push($product,$rows['stocktype']);
                    //$res[$i][] = $row;
                    array_push($res,$row);
                }
                /*$usedperday['records'][$i] = $res;
                echo json_encode($usedperday);*/
            }
}
$usedperday['records'] = $res;
echo json_encode($usedperday);








?>
