<?php 
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$output="";

$query="select product.*,brand.bname from product LEFT JOIN brand on product.brandid = brand.bid";
$result=mysqli_query($con, $query);
$res = array();
if(mysqli_num_rows($result)>0) {
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)) {
         $res[] = array('regno' =>$rows['regno'] , 'pname' => $rows['pname'],
                        'realregno' => $rows['realregno'],'pcore'=>$rows['pcore']
                       ,'pdesc'=>$rows['pdesc'],'brandid'=>$rows['brandid'],'brandName'=>$rows['bname']);

    }
    /*if($output !="") {
            $output .=",";
        }
        $output .='{"regno":"' . $rs["regno"] . '",';
        $output .='"pname":"' . $rs["pname"] . '",';
        $output .='"pcore":"' . $rs["pcore"] . '",';
        $output .='"pdesc":"' . $rs["pdesc"] . '",';  
        $output .='"brandid":"' . $rs["brandid"] . '",';  
        $output .='"brandName":"' . $rs["bname"] . '"}';
    $output = '{"records":['.$output.']}';
    echo($output);*/
    $product['records'] = $res;
echo json_encode($product);

}

?>
