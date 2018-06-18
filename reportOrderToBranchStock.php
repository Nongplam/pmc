<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'php/connectDB.php';

$userid = $_SESSION['id'];
$subid = $_SESSION['subbranchid'];
$rptsTbs_no = $_GET["no"];
$tobranchid = $_GET["br"];





$sql = "SELECT rpt_stocktobranchstock.*,subbranch.* 
FROM rpt_stocktobranchstock,subbranch 
WHERE rpt_stocktobranchstock.subbranchid = subbranch.id 
AND rpt_stocktobranchstock.subbranchid = $tobranchid  
AND rpt_stocktobranchstock.rptsTbs_no = '$rptsTbs_no'";
if($result = mysqli_query($con,$sql)){
    $row = $result->fetch_array(1);
   $sTbs_date = $row["rptsTbs_date"];
   $tB_name = $row["name"];
   $tB_info = $row["info"];
   $tB_tel =  $row["tel"];
   $sTbs_id = $row["rptsTbs_id"];
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

        <h4 lang="th" align="center"> ใบนำส่งสินค้า </h4>
        <h4 lang="th"> บริษัท สุมิตรเภสัช 21 หมู่ 6 ถ.ศรีจันทร์ ต.ในเมือง อ.เมือง ขอนแก่น 40000</h4>
        
                        <table border="1" lang="th" aling="right" width = "50%">
                            <tbody>
                                <tr>
                                    <th>เลขที่ใบนำส่ง</th>
                                    <td>
                                        <?=$rptsTbs_no?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>วันที่</th>
                                    <td>
                                        <?=$sTbs_date?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                
        <table border="1" lang="th" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 50%;">
                        <b aling="center">จาก</b>
                        <p>สาขา :
                            <?=$Bname?>
                        </p>
                      
                       
                        <br>
                        <p>ที่อยู่ :
                            <?=$Binfo?>
                        </p>
                        <br>
                        <p>โทร :
                            <?= $Btel?>
                        </p>
                       
                    </td>
                    <td style="width: 50%;">
                    <b aling="center">ไปที่</b>
                        <p>สาขา :
                            <?= $tB_name ?>
                        </p>
                        <br>
                        <p>ที่อยู่ :
                            <?=$tB_info?>
                        </p>
                        <br>
                        <p>โทร :
                            <?= $tB_tel?>
                        </p>

                    </td>
                </tr>
            </tbody>
        </table>

        <table border="1" lang="th" style="width: 100%;">
            <thead>
                <tr class="headerrow">
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>จำนวน</th>
                    <th>หน่วย</th>
                </tr>
            </thead>
            <tbody>
                <?php

        $sqlDe = "SELECT product.pname,rpt_stocktobranchstockdetail.rptsTbs_qty,stock.stocktype FROM rpt_stocktobranchstockdetail,stock,product WHERE rpt_stocktobranchstockdetail.stockid = stock.sid AND stock.productid = product.regno AND rpt_stocktobranchstockdetail.rptsTbs_id =  $sTbs_id  ORDER BY product.pname ASC";
            $c =0 ;
        if($result2 = mysqli_query($con,$sqlDe)){
            while ($rowD = $result2->fetch_array(1)) {
                ?>
                    <tr>
                        <td align="center">
                            <?=$c=$c+1?>
                        </td>
                        <td>
                            <?=$rowD["pname"]?>
                        </td>
                        <td align="center">
                            <?=$rowD["rptsTbs_qty"]?>
                        </td>
                        
                        <td align="center">
                            <?=$rowD["stocktype"]?>
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

$mpdf->SetHeader('|<p lang="th">หน้า {PAGENO}/{nbpg}</p>|<p lang="th">ใบนำส่งเลขที่ : '.$rptsTbs_no.' </p>');
$mpdf->setFooter("<table   style='width: 100%;' lang='th' >
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
    </table>");


$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
$mpdf->defaultfooterline=4;
// Load a stylesheet
$stylesheet = file_get_contents('css/mpdfstyletables.css');

$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html,2);



// Output a PDF file directly to the browser
$mpdf->Output("TBS_".$rptsTbs_no.".pdf", 'I');
?>
