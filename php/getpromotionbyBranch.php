<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$subid= $_SESSION['subbranchid'];

if($data) {
    $branchid=74;// mysqli_real_escape_string($con, $data->branch);    
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
    $branchid=74;// mysqli_real_escape_string($con, $data->branch);    
    //$sql="SELECT * FROM promotion WHERE promotion.subbranchid = '$branchid'";
    $sql="SELECT * FROM promotion WHERE promotion.subbranchid = '$branchid'";
    $res = array();
    
    if($result = mysqli_query($con,$sql)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $promotioninbranch['records']= $res;
        //echo   json_encode($promotioninbranch);
    }
    for($i = 0;$i<count($promotioninbranch['records']);$i++){        
        //echo $promotioninbranch['records'][$i]['stockidwithqty'];
        
        $temparr = explode(",",$promotioninbranch['records'][$i]['stockidwithqty']);
        //print_r ($temparr);
        for($j = 0;$j<count($temparr);$j++){            
            $temparr2 = explode("=",$temparr[$j]);
            $searchdupquery="";
                $searchdupresult = mysqli_query($con, $searchdupquery);
                $searchduprows = mysqli_fetch_assoc($searchdupresult);
    
                $preid = $searchduprows['id'];
                $preqty = $searchduprows['qty'];
            print_r($temparr2);
        }
    }
}


?>
