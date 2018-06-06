<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$subbranchid = $_SESSION["subbranchid"];
$userrole = $_SESSION["role"];


if($userrole == "manager"){
    
    $stocknotinshelfquery="SELECT stock.sid,stock.lotno,product.pname FROM stock,product WHERE stock.sid NOT IN (SELECT shelf.stockid FROM shelf WHERE shelf.subbranchid = $subbranchid AND shelf.stockid IS NOT NULL) AND product.regno = stock.productid AND stock.subbranchid = $subbranchid AND stock.remain >= 1";

if($result=  mysqli_query($con,$stocknotinshelfquery)){
                $res = array();
                while ($row = $result->fetch_array(1)){
                    $res[] = $row;
                }
                $noti['records'] = $res;
                //echo json_encode($noti);
    //print_r($noti);
    //echo $noti['records'][0]['lotno'];
    //echo count($noti['records']);
    /*echo "<table class='table table'>";
    for($i = 0;$i < count($noti['records']);$i++){
        //echo $noti['records'][$i]['lotno'];
        echo "<a class='dropdown-item' href='#'>#1 : สินค้าไม่ถูกจัดขึ้นชั้นวาง</a>";
    }
    
    echo "</div>";*/
    
    echo "<table class='table table-bordered'>";
        echo "<thead class='bg-info'>";    
    
        echo "<tr>";
              echo "<th class='text-light'> รายการสินค้าที่ยังไม่เบิกขึ้นชั้นวาง </th>";
        echo "</tr>";    
                                
                                    
        echo "</thead>";
        echo "<tbody>";
for($i = 0;$i < count($noti['records']);$i++){
        echo "<tr class='notirow'>";
            echo "<td>"; echo $noti['records'][$i]['pname']; echo "</td>";
        echo "</tr>";
}
        echo "</tbody>";
    echo "</table>";                    
    
            }
    
}else{
    
    echo "<h1> คุณไม่มีรายการแจ้งเตือน </h1>";
    
}



?>
