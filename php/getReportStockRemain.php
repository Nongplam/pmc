<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("14", $allowrule)){
            echo $allowrule;
            echo "Eooe";
        }else{
            $id=$_GET['branch'];
    $query="SELECT  stock.sid,product.pname ,stock.productid,company.cname,stock.remain,stock.stocktype,stock.costprice,stock.lotno,stock.receiveday,stock.expireday 
    FROM stock,product,company WHERE (stock.productid = product.regno AND stock.cid = company.cid) 
    AND DATE(stock.expireday) >= NOW() AND stock.remain != 0 AND stock.subbranchid = ".$id." ORDER BY stock.remain ASC";
    $result = mysqli_query($con,$query);    


    $res = array();
while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
    
    $res[] = array('sid' =>$rows['sid'],'pname' =>$rows['pname'],'productid' =>$rows['productid'],'cname' =>$rows['cname'],'remain' =>$rows['remain']
    ,'stocktype' =>$rows['stocktype'],'costprice' =>$rows['costprice'],'lotno' =>$rows['lotno'],'receiveday' =>$rows['receiveday'],'expireday' =>$rows['expireday'] );
}
$stocks['records'] = $res;
echo json_encode($stocks);
        }

