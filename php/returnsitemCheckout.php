<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));

$userid = $_SESSION["id"];
$subbranchid = $_SESSION["subbranchid"];

if($data){
    $ddid = mysqli_real_escape_string($con, $data->ddid);
    $ddidarr = array_filter(explode(",",$ddid));
    $moneyreturntotal = 0;
    //เพิ่มข้อมูลรายการคืนของและอัพเดทบิล
    for($i = 0;$i < count($ddidarr);$i++){
        $dailydquery="SELECT dailysaledetail.* FROM dailysaledetail WHERE dailysaledetail.ddid = '$ddidarr[$i]' AND dailysaledetail.subbranchid = '$subbranchid'";
        $dailydresult = mysqli_query($con, $dailydquery);
        $dailydrows = mysqli_fetch_assoc($dailydresult);
        $ddidtemp = $dailydrows['ddid'];
        $qtytemp = $dailydrows['qty'];
        $pricetemp = $dailydrows['price'];
        $stockidtemp = $dailydrows['stockid'];
        $moneybacktemp = $dailydrows['qty']*$dailydrows['price'];
        $moneyreturntotal = $moneyreturntotal + $moneybacktemp;
        $masterid = $dailydrows['masterid'];
        $addtoreturnslistquery="INSERT INTO returnitem(ddid, qty, price, moneyback, stockid, userid, subbranchid) VALUES ('$ddidtemp','$qtytemp','$pricetemp','$moneybacktemp','$stockidtemp','$userid','$subbranchid')";
        mysqli_query($con, $addtoreturnslistquery);
        $updatedailydquery="UPDATE dailysaledetail SET dailysaledetail.status = '2' WHERE dailysaledetail.ddid = '$ddidtemp'";
        mysqli_query($con, $updatedailydquery);
    }
    //Update status master bill
    $updatestatusmasterquery="UPDATE dailysalemaster SET dailysalemaster.status = '2' WHERE dailysalemaster.dmid = '$masterid'";
    mysqli_query($con, $updatestatusmasterquery);
        
    //สร้างเลขที่บิลใหม่
    $maxbillnoquery="SELECT MAX(billno) as billno FROM dailysalemaster WHERE dailysalemaster.subbranchid = '$subbranchid'";
    $maxbillnoresult = mysqli_query($con, $maxbillnoquery);
    $maxbillnorows = mysqli_fetch_assoc($maxbillnoresult);
    if($maxbillnorows['billno'] == NULL){
        $newbillid = sprintf("%010d", 1);
    }else{
        $newbillid = sprintf("%010d", $maxbillnorows['billno']+1);
    }
    
    //ดึงรายละเอียดบิลเก่า
    $oldbilldetailquery="SELECT * FROM dailysalemaster WHERE dailysalemaster.dmid = '$masterid' AND dailysalemaster.subbranchid = '$subbranchid'";
    $dailymresult = mysqli_query($con, $oldbilldetailquery);
    $dailymrows = mysqli_fetch_assoc($dailymresult);
    $oldsumprice = $dailymrows['sumprice'];
    $newsumprice = $oldsumprice - $moneyreturntotal;
    $oldmemberid = $dailymrows['memberid'];
    $oldpaymethod = $dailymrows['paymethod'];
    $oldmoneyreceive = $dailymrows['moneyreceive'];
    $newmoneyreceive = $oldmoneyreceive - $moneyreturntotal;
    $oldmoneychange = $dailymrows['moneychange'];
    $olduserid = $dailymrows['userid'];
    $oldsubbranchid = $dailymrows['subbranchid'];
    $billkey = uniqid();
    
    //เพิ่มข้อมูลบิลใหญ่ใหม่
    $newmasterbillquery="insert into dailysalemaster(billno,sumprice,memberid,moneyreceive,moneychange,userid,subbranchid,paymethod,refkey,frommasterid) values('$newbillid','$newsumprice','$oldmemberid','$newmoneyreceive','$oldmoneychange','$olduserid','$oldsubbranchid','$oldpaymethod','$billkey','$masterid')";
    mysqli_query($con, $newmasterbillquery);
    
    //หา id ของบิลที่เพิ่มไป
    $newmasteridquery = "select MAX(dmid) as dmid from dailysalemaster WHERE dailysalemaster.subbranchid = '$oldsubbranchid' AND dailysalemaster.userid = '$olduserid'";
    $newmasteridresult = mysqli_query($con, $newmasteridquery);
    $newmasteridrows = mysqli_fetch_assoc($newmasteridresult);
    $newmasterid = $newmasteridrows['dmid'];
    
    //ดึงข้อมูลสินค้าที่เหลือจากบิลล่าสุด
    $dailybillquery = "SELECT * FROM dailysaledetail WHERE dailysaledetail.masterid = '$masterid' AND dailysaledetail.status = '1'";
    $dailybillresult = mysqli_query($con,$dailybillquery);
    $newstockid = array();
    $newqty = array();
    $newprice = array();
    while ($rows = $dailybillresult->fetch_array(MYSQLI_ASSOC)){
        array_push($newstockid,$rows['stockid']);
        array_push($newprice,$rows['price']);
        array_push($newqty,$rows['qty']);
    }
    
    //echo count($newstockid);
    //เพิ่มข้อมูลบิลเล็กใหม่
    for($j = 0;$j < count($newstockid);$j++){
        
        $newdetialbillquery="insert into dailysaledetail(masterid,stockid,qty,price,userid,subbranchid) values('$newmasterid','$newstockid[$j]','$newqty[$j]','$newprice[$j]','$olduserid','$oldsubbranchid')";
        if(mysqli_query($con, $newdetialbillquery)) {
            echo "detail Inserted";            
        }
        else {
            echo "detail Error";
        }
    }
    
    //Update ข้อมูลบิลเล็กเป็นโหมด 3
    $updatedailydmode3query="UPDATE dailysaledetail SET dailysaledetail.status = '3' WHERE dailysaledetail.masterid = '$masterid' AND dailysaledetail.status = '1'";
    mysqli_query($con, $updatedailydmode3query);
    
    
    
    
    
}

?>
