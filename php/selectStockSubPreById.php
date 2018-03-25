<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

if($data) {

    $subid = mysqli_real_escape_string($con,$data->subid);

        $sql ="SELECT 	branchstockprepare.bSP_id,product.pname,product.realregno,stock.lotno,branchstockprepare.bSP_qty,stock.stocktype FROM product,stock,branchstockprepare 
                WHERE stock.sid = branchstockprepare.stockid AND stock.productid = product.regno AND branchstockprepare.subbranchid = ".$subid;


        $result = mysqli_query($con,$sql);
        $res = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)){

            $res[] = array('bSP_id' => $row["bSP_id"],'pname' => $row["pname"],'realregno' => $row["realregno"],'bSP_qty' => $row["bSP_qty"],'lotno' => $row["lotno"],'stocktype' => $row["stocktype"]);

        }
        $stockPre['records']= $res;

       echo   json_encode($stockPre);
}