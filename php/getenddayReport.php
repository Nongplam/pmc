<?php 

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$masterbranchid=$_SESSION["masterbranchid"];
if($data){
    $datestart=mysqli_real_escape_string($con, $data->datestart);
    $dateend=mysqli_real_escape_string($con, $data->dateend);    
    
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
    $branchid = $branchidres[$i];
    $stm="SELECT name,subbranchid,COUNT(name) AS totalbill,SUM(sumprice) AS totalsale,SUM(costprice) AS totalcost,SUM(profit) AS totalprofit FROM (SELECT *,(sumprice-costprice) AS profit FROM (SELECT subbranch.name,dailysalemaster.subbranchid,dailysalemaster.dmid,dailysalemaster.sumprice,SUM(stock.costprice*dailysaledetail.qty) AS costprice FROM subbranch,stock,dailysaledetail,dailysalemaster WHERE stock.sid = dailysaledetail.stockid AND dailysaledetail.masterid = dailysalemaster.dmid AND subbranch.id = dailysalemaster.subbranchid AND dailysalemaster.subbranchid = $branchid AND dailysalemaster.masterdate >= '$datestart 00:00:00' AND dailysalemaster.masterdate <= '$dateend 23:59:59' AND dailysalemaster.status = 1 GROUP BY dailysalemaster.dmid) AS T1) AS T2 GROUP BY name";
    if($result=  mysqli_query($con,$stm)){
                
                while ($row = $result->fetch_array(1)){
                    if($row['totalbill'] != null){
                        array_push($res,$row);
                    }
                    
                }
            }    
}

$report['records'] = $res;
echo json_encode($report);
}
