<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {
    $branchid=mysqli_real_escape_string($con, $data->branch);    
    $sql="SELECT * FROM promotion WHERE promotion.subbranchid = '$branchid'";
    $res = array();
    
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $promotioninbranch['records']= $res;
        echo   json_encode($promotioninbranch);
    }
}else{
    $branchid=mysqli_real_escape_string($con, $data->branch);    
    //$sql="SELECT * FROM promotion WHERE promotion.subbranchid = '$branchid'";
    $sql="SELECT * FROM promotion WHERE promotion.subbranchid = '$branchid'";
    $res = array();
    $detail = array();
    
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $promotioninbranch['records']= $res;
        echo   json_encode($promotioninbranch);
        //print_r($promotioninbranch);
    }
    /*for($i = 0;$i<count($promotioninbranch['records']);$i++){        
        //echo $promotioninbranch['records'][$i]['stockidwithqty'];
        //echo "รายการที่ $i\n";
        
        $temparr = explode(",",$promotioninbranch['records'][$i]['stockidwithqty']);
        //print_r ($temparr);
        for($j = 0;$j<count($temparr);$j++){            
            $temparr2 = explode("=",$temparr[$j]);
            //print_r($temparr2);
            $pnamequery="SELECT product.pname FROM stock,product WHERE product.regno = stock.productid AND stock.sid = '$temparr2[0]'";            
            $pnameresult = mysqli_query($con, $pnamequery);
            $pnamerows = mysqli_fetch_assoc($pnameresult);    
            $panme = $pnamerows['pname'];
            echo $panme;
            echo " ";
            
            echo $temparr2[1]."\n";
            array_push($detail,$panme);
            array_push($detail,$temparr2[1]);
            
            //$preqty = $pnamerows['qty'];
            //echo $preid;
            //echo $preqty;
            //
        }
    }*/
}


?>
