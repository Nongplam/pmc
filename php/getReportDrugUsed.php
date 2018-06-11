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
    $branchidres =   $res;
}else{
    echo mysqli_error($con);
}

$res = array();
$res2 = array();
for($i = 0;$i<count($branchidres);$i++){
    //echo $i;
    
    $branchid = $branchidres[$i];
 $reportdrugused="SELECT T.*,T2.* FROM (SELECT stock.subbranchid,subbranch.name,stock.productid AS mainpid,product.pname AS pname ,stock.stocktype AS mainstocktype,(SELECT SUM(stock.remain) FROM stock WHERE stock.subbranchid = '$mainbranchid' AND stock.productid = mainpid AND stock.stocktype = mainstocktype) AS mainbranchremain,SUM(stock.remain) AS branchremain FROM stock,product,subbranch WHERE product.regno = stock.productid AND subbranch.id = stock.subbranchid AND stock.subbranchid = '$branchid' GROUP BY product.pname,stock.stocktype) T, (SELECT product.pname AS branchpname,IF(SUM(dailysaledetail.qty)/(SELECT DATEDIFF(NOW(),MIN(dailysaledetail.date)) FROM dailysaledetail,stock,product WHERE dailysaledetail.subbranchid = '$branchid' AND product.regno = stock.productid AND stock.sid = dailysaledetail.stockid AND product.pname = branchpname)>0,SUM(dailysaledetail.qty)/(SELECT DATEDIFF(NOW(),MIN(dailysaledetail.date)) FROM dailysaledetail,stock,product WHERE dailysaledetail.subbranchid = '$branchid' AND product.regno = stock.productid AND stock.sid = dailysaledetail.stockid AND product.pname = branchpname),SUM(dailysaledetail.qty)/1) AS aveusedperday,stock.stocktype AS stocktype FROM dailysaledetail,stock,product WHERE dailysaledetail.subbranchid = '$branchid' AND product.regno = stock.productid AND stock.sid = dailysaledetail.stockid GROUP BY product.pname,stock.stocktype) T2 WHERE T.pname = T2.branchpname AND T.mainstocktype = T2.stocktype";


if($result=  mysqli_query($con,$reportdrugused)){
                
                while ($row = $result->fetch_array(1)){
                    //array_push($product,$rows['stocktype']);
                    //$res[$i][] = $row;
                    array_push($res,$row);
                }
                /*$usedperday['records'][$i] = $res;
                echo json_encode($usedperday);*/
            }
    $remaininshelf="SELECT SUM(shelf.shelfremain) AS totalonshelf,product.pname,product.regno,stock.stocktype,shelf.subbranchid FROM shelf,product,stock WHERE product.regno = stock.productid AND stock.sid = shelf.stockid AND shelf.subbranchid = '$branchid' GROUP BY product.regno,stock.stocktype";
    if($result2=  mysqli_query($con,$remaininshelf)){
                
                while ($row2 = $result2->fetch_array(1)){
                    //array_push($product,$rows['stocktype']);
                    //$res[$i][] = $row;
                    array_push($res2,$row2);
                }
                /*$usedperday['records'][$i] = $res;
                echo json_encode($usedperday);*/
            }
    
    
}

for($j = 0;$j<count($res2);$j++){
    for($k = 0;$k<count($res);$k++){
        if($res[$k]['mainpid'] == $res2[$j]['regno'] && $res[$k]['mainstocktype'] == $res2[$j]['stocktype'] && $res[$k]['subbranchid'] == $res2[$j]['subbranchid']){
            $res[$k]['branchremain'] = $res[$k]['branchremain'] + $res2[$j]['totalonshelf'];
        }
    }
}
$usedperday['records'] = $res;
//$usedperday['records'] = $res2;
echo json_encode($usedperday);
//print_r($res2);







?>
