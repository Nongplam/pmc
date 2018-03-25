<?php


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
 $id  = 2 /*$_SESSION["id"] */;

$mbranchid = 70 /*$_SESSION["masterbranchid"] */;
 
 
 
 if($data) {

     $subid = mysqli_real_escape_string($con, $data->subid);

     $res[] = array('addMrpt'=>'Failed','addDrpt'=>'Failed','UpStock'=>'Failed','DelPreStock'=>'Failed');
     $sqlRptNo = "SELECT MAX(rpt_stocktobranchstock.rptsTbs_no) as rptsTbs_no FROM rpt_stocktobranchstock";
     $resultRptNo  =  mysqli_query($con,$sqlRptNo);
     $rowRptNo  = $resultRptNo ->fetch_array(1);
     $rptNoD = $rowRptNo['rptsTbs_no'];
     $rptNo = sprintf("%'.010d", $rptNoD+1);




     $sqlInrpt="INSERT INTO rpt_stocktobranchstock (rptsTbs_no,	rptsTbs_date,rptsTbs_desc,rptsTbs_status,mbranchid,subbranchid,userid) 
                VALUES('$rptNo',NOW(),'stocktostockbranch','0',$mbranchid,$subid,$id)";

    if (mysqli_query($con,$sqlInrpt)){
        $res[0]['addMrpt'] = 'Successed' ;
    }


    $sqlRptId = "SELECT rptsTbs_id FROM rpt_stocktobranchstock  WHERE rptsTbs_no = $rptNo";
    $resultRptId = mysqli_query($con,$sqlRptId);
    $rowRptId = $resultRptId->fetch_array(1);
     $rptId  = $rowRptId['rptsTbs_id'];


    $sqlInBrDe = "INSERT INTO rpt_stocktobranchstockdetail (rptsTbs_id,stockid,rptsTbs_qty,userid) SELECT $rptId,stockid,bSP_qty,$id  FROM branchstockprepare WHERE subbranchid = $subid";
    if (mysqli_query($con,$sqlInBrDe)){
        $res[0]['addDrpt'] = 'Successed' ;
    }

    $sqlUpstock  = "UPDATE stock s, branchstockprepare p SET s.remain = (s.remain -p.bSP_qty) WHERE s.sid = p.stockid AND p.subbranchid = $subid";

     if (mysqli_query($con,$sqlUpstock)){
         $res[0]['UpStock'] = 'Successed' ;
     }

    $sqlDelPreStock = "DELETE FROM branchstockprepare  WHERE subbranchid = $subid";
     if (mysqli_query($con,$sqlDelPreStock)){
         $res[0]['DelPreStock'] = 'Successed' ;
     }


     $pre['results'] = $res;
     echo json_encode($pre);


   /*

     $lenrptNo = 10-strlen($rptNoUp);
     $rptNo = "";

     for ($i = 1; $i <= $lenrptNo; $i++) {
         $rptNo = $rptNo.'0';
     }

     $rptNo = $rptNo.$rptNoUp;
 */




 }

?>