<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'php/connectDB.php';

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];
$no = $_GET["no"];






$sql = "SELECT * FROM rpt_stocktoshelf WHERE rpt_stocktoshelf.rptno = '$no' AND  rpt_stocktoshelf.subbranchid = $subid ";

if($result = mysqli_query($con,$sql)){
    $row = $result->fetch_array(1);
    $rptid = $row["rptid"];
    $rptno = $row["rptno"];
    $date = $row["rptdate"];
    $rptdesc = $row["rptdesc"];
   
}

$sqlBranch = "SELECT * FROM subbranch WHERE  subbranch.id = $subid";
if($resultBranch = mysqli_query($con,$sqlBranch)){
    $rowBranch = $resultBranch ->fetch_array(1);
    $Bname = $rowBranch["name"];
    $Binfo = $rowBranch ["info"];
    $Btel = $rowBranch ["tel"];
}

ob_start();
?>

    <div lang="th">

        <h4 lang="th" align="center"> ใบนำทางสินค้าเข้าชั้นวาง </h4>
        <h4 lang="th"><?="สาขา. "?><?=$Bname?><?=" "?><?=$Binfo?><?=" โทร. "?><?=$Btel?></h4>
        
        <table border="1" lang="th"  width = "100%">
            <tbody>
                <tr>
                    <th  width = "20%">เลขที่ใบนำทาง</th>
                    <td  width = "30%">
                        <?=$rptno ?>
                    </td>
                    <th  width = "20%">วันที่</th>
                    <td width = "30%">
                        <?=$date?>
                    </td>
                </tr>
                               
             </tbody>
        </table>

  <table border="1" lang="th" style="width: 100%;">
            <thead>
                <tr class="headerrow">
                    <th>#</th>
                    <th>สินค้า</th>
                    <th>เลขล็อต</th>
                    <th>จำนวน</th>
                    <th>หน่วย</th>
                    <th>ไปที่</th>
                    <th>ชั้นวางเลขที่</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
        <?PHP
        $sqlSlectDetailToSelf = "SELECT product.pname, stock.lotno, rpt_stocktoshelfdetail.qty, stock.stocktype, rpt_stocktoshelfdetail.toshelfno, shelf.shelfinfo FROM stock, product, shelf, rpt_stocktoshelfdetail WHERE stock.productid = product.regno AND rpt_stocktoshelfdetail.stockid = stock.sid AND stock.sid = shelf.stockid AND rpt_stocktoshelfdetail.toshelfno = shelf.shelfno AND rpt_stocktoshelfdetail.rptid =  $rptid  AND rpt_stocktoshelfdetail.subbranchid = $subid";
        $c =0 ;
        if(  $resultDetailToSelf = mysqli_query($con,$sqlSlectDetailToSelf)){
            while($rowDetailToSelf = $resultDetailToSelf->fetch_array(1) ){

               ?>

                <tr>
                        <td align="center">
                            <?=$c=$c+1?>
                        </td>
                        <td>
                            <?=$rowDetailToSelf["pname"]?>
                        </td>
                        <td align="center">
                            <?=$rowDetailToSelf["lotno"]?>
                        </td>
                        
                        <td align="center">
                            <?=$rowDetailToSelf["qty"]?>
                        </td>
                        <td align="center">
                            <?=$rowDetailToSelf["stocktype"]?>
                        </td>
                        <td align="center">
                            <?="->"?>
                        </td>
                        <td align="center">
                            <?=$rowDetailToSelf["toshelfno"]?>
                        </td>
                        <td align="center">
                            <?=$rowDetailToSelf["shelfinfo"]?>
                        </td>
                    </tr>
               <?php     
            }
        }
        
        ?>
          </tbody>
        </table>
       






    </div>

    <?php

$html = ob_get_contents();

ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => [190, 236],
    'setAutoBottomMargin' => 'pad',
    'autoLangToFont' => true
]);


$mpdf->pdf_version = '7.0.3';

$mpdf->SetHeader('|<p lang="th">หน้า {PAGENO}/{nbpg}</p>|<p lang="th">เลขที่ใบนำทาง : '.$rptno.' </p>');
/*$mpdf->setFooter("<table   style='width: 100%;' lang='th' >
        <tbody>
        <tr>
            <td style='width: 50%;text-align: center;'>
                <p >ผู้ส่ง</p>
                <br>
                <p >...............................................................</p>
                <p >(	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;  &#160;	&#160;	&#160;	&#160;	&#160;	&#160; 	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;)</p>
                <br>
                <p >วันที่ ........./........./..............</p>
            </td>
            <td style='width: 50%;text-align: center;'>
                <p>ผู้รับ</p>
                <br>
                <p >...............................................................</p>
                <p>(	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;)</p>
                <br>
                <p >วันที่ ........./........./..............</p>

            </td>
            
        </tr>
        </tbody>
    </table>");*/


$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
$mpdf->defaultfooterline=4;
// Load a stylesheet
$stylesheet = file_get_contents('css/mpdfstyletables.css');

$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html,2);



// Output a PDF file directly to the browser
$mpdf->Output("TBS_".$rptsTbs_no.".pdf", 'I');
?>
