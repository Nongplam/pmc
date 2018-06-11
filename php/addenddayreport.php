<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$subbranchid= $_SESSION['subbranchid'];
$mydate=getdate(date("U"));
//echo "$mydate[year]-$mydate[mon]-$mydate[mday]";
$currentdate = "$mydate[year]-$mydate[mon]-$mydate[mday]";

//echo $currentdate;
$maxlistquery="SELECT rpt_endday.totalbill FROM rpt_endday WHERE rpt_endday.subbranchid = $subbranchid AND rpt_endday.date = '$currentdate 23:59:59'";
    $maxlistresult = mysqli_query($con, $maxlistquery);
    $maxlistrows = mysqli_fetch_assoc($maxlistresult);
    $totalbill = $maxlistrows['totalbill'];
if($totalbill > 0){
    echo "Dup";
}else{
    $stm="INSERT INTO rpt_endday(subbranchid, totalbill, totalcost, totalprofit, totalsale, date) SELECT dailysalemaster.subbranchid,(SELECT COUNT(dailysalemaster.dmid) FROM dailysalemaster WHERE dailysalemaster.subbranchid = '$subbranchid' AND dailysalemaster.masterdate >= '$currentdate 00:00:00' AND dailysalemaster.masterdate <= '$currentdate 23:59:59') AS totalbill,SUM(stock.costprice*dailysaledetail.qty) AS totalcost,(SUM(dailysalemaster.sumprice)-SUM(stock.costprice*dailysaledetail.qty)) AS totalprofit,SUM(dailysalemaster.sumprice) AS totalsale,('$currentdate 23:59:59') AS date FROM dailysalemaster,dailysaledetail,stock WHERE stock.sid = dailysaledetail.stockid AND dailysaledetail.masterid = dailysalemaster.dmid AND dailysalemaster.subbranchid = '$subbranchid' AND dailysalemaster.masterdate >= '$currentdate 00:00:00' AND dailysalemaster.masterdate <= '$currentdate 23:59:59'";
    if(mysqli_query($con, $stm)) {
        echo "Data Inserted";
        
        }
        else {
            echo "Error";
        }
}





/*$subbranchid= 73;
    $datestr = "2018-04-23";
    $dateday = date_create_from_format("Y-m-d",$datestr);
    //echo date_format($dateday,"d/m/Y");
    //echo "<br>";
    //echo date_format($dateday,"d");
//$day = date_format($dateday,"d");
$day = "01";
$month = date_format($dateday,"m");
$month++;
$month++;
$year = date_format($dateday,"Y");
$strdate = $year . "-" . $month . "-" . $day;
for($i = 0 ; $i<30;$i++){
    $stm="INSERT INTO rpt_endday(subbranchid, totalbill, totalcost, totalprofit, totalsale, date) SELECT dailysalemaster.subbranchid,(SELECT COUNT(dailysalemaster.dmid) FROM dailysalemaster WHERE dailysalemaster.subbranchid = '$subbranchid' AND dailysalemaster.masterdate >= '$strdate 00:00:00' AND dailysalemaster.masterdate <= '$strdate 23:59:59') AS totalbill,SUM(stock.costprice*dailysaledetail.qty) AS totalcost,(SUM(dailysalemaster.sumprice)-SUM(stock.costprice*dailysaledetail.qty)) AS totalprofit,SUM(dailysalemaster.sumprice) AS totalsale,('$strdate 23:59:59') AS date FROM dailysalemaster,dailysaledetail,stock WHERE stock.sid = dailysaledetail.stockid AND dailysaledetail.masterid = dailysalemaster.dmid AND dailysalemaster.subbranchid = '$subbranchid' AND dailysalemaster.masterdate >= '$strdate 00:00:00' AND dailysalemaster.masterdate <= '$strdate 23:59:59'";
    if(mysqli_query($con, $stm)) {
        echo "Data Inserted";
        
        }
        else {
            echo "Error";
        }
    $day++;
    $strdate = $year . "-" . $month . "-" . $day;
    
}*/
    

    /*$stm="INSERT INTO rpt_endday(subbranchid, totalbill, totalcost, totalprofit, totalsale, date) SELECT dailysalemaster.subbranchid,(SELECT COUNT(dailysalemaster.dmid) FROM dailysalemaster WHERE dailysalemaster.subbranchid = $subbranchid AND dailysalemaster.masterdate >= '$datestr 00:00:00' AND dailysalemaster.masterdate <= '$datestr 23:59:59') AS totalbill,SUM(stock.costprice*dailysaledetail.qty) AS totalcost,(SUM(dailysalemaster.sumprice)-SUM(stock.costprice*dailysaledetail.qty)) AS totalprofit,SUM(dailysalemaster.sumprice) AS totalsale,('$datestr 23:59:59') AS date FROM dailysalemaster,dailysaledetail,stock WHERE stock.sid = dailysaledetail.stockid AND dailysaledetail.masterid = dailysalemaster.dmid AND dailysalemaster.subbranchid = $subbranchid AND dailysalemaster.masterdate >= '$datestr 00:00:00' AND dailysalemaster.masterdate <= '$datestr 23:59:59'";
    echo $stm;*/
?>
