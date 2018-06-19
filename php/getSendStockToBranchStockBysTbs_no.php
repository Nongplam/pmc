<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {

    $sTbs_no= mysqli_real_escape_string($con, $data->sTbs_no);
    echo $sTbs_no;
    echo $subid;


    $sql = "SELECT rpt_stocktobranchstock.*,rpt_stocktobranchstockdetail.*,product.pname,stock.productid,stock.stocktype FROM rpt_stocktobranchstock,rpt_stocktobranchstockdetail,product,stock  
            WHERE product.regno = stock.productid AND rpt_stocktobranchstockdetail.stockid = stock.sid AND rpt_stocktobranchstock.rptsTbs_id = rpt_stocktobranchstockdetail.rptsTbs_id AND rpt_stocktobranchstockdetail.sts = '1'  AND rpt_stocktobranchstock.rptsTbs_no =  '$sTbs_no' AND rpt_stocktobranchstock.subbranchid = '$subid'" ;
    $res = array();
    //echo  $sql;
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $sTbs['records']= $res;
        echo   json_encode($sTbs);
    }

}else{

    echo "failed";
}



?>
