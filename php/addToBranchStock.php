<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = 31/* $_SESSION['id']*/;
$subid = 1/*$_SESSION['subbranchid']*/;
if($data) {
        $rtsTbsNo = mysqli_real_escape_string($con,$data -> rptsTbsNo);
        $stockid = mysqli_real_escape_string($con,$data->stockid);
        $qty = mysqli_real_escape_string($con,$data -> qty);

        $result = array('addStock'=> 'Failed','upstsdetail' =>'Failed');

        $sql = "INSERT INTO drugstorerx.stock
(
productid,
cid,
remainfull,
remain,
lotno,
stocktype,
costprice,
baseprice,
boxprice,
retailprice,
wholesaleprice,
receiveday,
expireday,
subbranchid,
userid) SELECT stock.productid,stock.cid,$qty as remainfull,$qty as remain,stock.lotno,stock.stocktype,stock.costprice,stock.baseprice,stock.boxprice,stock.retailprice,stock.wholesaleprice,NOW(),stock.expireday,$subid as subbranchid,$userid as userid FROM stock,rpt_stocktobranchstockdetail 
WHERE rpt_stocktobranchstockdetail.stockid = stock.sid AND rpt_stocktobranchstockdetail.stockid = $stockid 
AND rpt_stocktobranchstockdetail.rptsTbs_id = (SELECT rpt_stocktobranchstock.rptsTbs_id FROM rpt_stocktobranchstock where rpt_stocktobranchstock.rptsTbs_no = '$rtsTbsNo')";




        if(mysqli_query($con,$sql)){

            $result[0]['addStock'] = 'Successed';
        }

        $sqlUp = "update drugstorerx.rpt_stocktobranchstockdetail set rpt_stocktobranchstockdetail.sts = '0' where rpt_stocktobranchstockdetail.stockid = $stockid and rpt_stocktobranchstockdetail.rptsTbs_id = (SELECT rpt_stocktobranchstock.rptsTbs_id FROM rpt_stocktobranchstock where rpt_stocktobranchstock.rptsTbs_no = '$rtsTbsNo')";


        if(mysqli_query($con,$sqlUp)){
            $result[0]['upstsdetail'] = 'Successed';

        }

        echo  json_encode($result);

}


