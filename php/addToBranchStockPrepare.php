<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
 $id  = $_SESSION["id"];
if($data) {
    $stockid=mysqli_real_escape_string($con,$data->stockid);
    $qty=mysqli_real_escape_string($con,$data->qty);
    $subid = mysqli_real_escape_string($con,$data->subid);
    $bSP_stockid = "";


    $sqlCh = " SELECT branchstockprepare.bSP_id,branchstockprepare.stockid,branchstockprepare.bSP_qty,branchstockprepare.subbranchid FROM branchstockprepare WHERE branchstockprepare.stockid = ".$stockid." and branchstockprepare.subbranchid = '$subid'" ;
     $result = mysqli_query($con,  $sqlCh);
     if($row = $result -> fetch_array(MYSQLI_ASSOC)) {
         $bSP_id = $row["bSP_id"];
         $bSP_stockid = $row['stockid'];
         $bSP_qty = $row['bSP_qty'];
         $bSP_subid = $row['subbranchid'];
         
     }

    $sql="";
        echo "stock = ".$bSP_stockid;
        echo "stock = ".$bSP_subid;
        echo "stock = ".$subid;
    if($bSP_stockid == $stockid && $bSP_subid ==  $subid  ){
        $sql= "UPDATE branchstockprepare SET branchstockprepare.bSP_qty = ". ($bSP_qty + $qty) ." WHERE branchstockprepare.bSP_id = ".$bSP_id;
        if(mysqli_query($con, $sql)) {
        echo "Data Updated";
    }
    else {
        echo "Insert Error";
    }
    }else{
        $sql= "INSERT INTO `branchstockprepare`( `stockid`, `bSP_qty`, `subbranchid`, `userid`) VALUES ($stockid,$qty,$subid,$id)";
        if(mysqli_query($con, $sql)) {
        echo "Data Inserted";
    }
    else {
        echo "Insert Error";
    }
    }

    




}