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
    $stm="SELECT rpt_endday.subbranchid,subbranch.name,SUM(rpt_endday.totalbill) as totalbill,SUM(rpt_endday.totalcost) AS totalcost,SUM(rpt_endday.totalprofit) AS totalprofit,SUM(rpt_endday.totalsale) AS totalsale FROM rpt_endday,subbranch WHERE rpt_endday.subbranchid = '$branchid' AND subbranch.id = rpt_endday.subbranchid AND rpt_endday.date >= '$datestart 00:00:00' AND rpt_endday.date <= '$dateend 23:59:59'";
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
