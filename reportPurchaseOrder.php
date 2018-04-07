<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'php/connectDB.php';


$poNO = $_GET["NO"];

$sql = "SELECT rpt_PO.*,company.cname FROM rpt_PO,company WHERE company.cid = rpt_PO.cid  AND rptPO_no = '$poNO'";
if($result = mysqli_query($con,$sql)){
    $row = $result->fetch_array(1);

    $rptPO_no = $row["rptPO_no"];
    $cname = $row["cname"];
    $rptPO_agent = $row["rptPO_agent"];
    $rptPO_lo = $row["rptPO_lo"];
    $rptPO_tel = $row["rptPO_tel"];
    $rptPO_mail = $row["rptPO_mail"];
    $rptPO_vatNo = $row["rptPO_vatNo"];
    $rptPO_losend = $row["rptPO_losend"];
    $rptPO_date = $row["rptPO_date"];
    $rptPO_datesend = $row["rptPO_datesend"];
    $pricesum = $row["pricesum"];
    $pricediscount = $row["pricediscount"];
    $priceMIdicount = $row["priceMIdicount"];
    $pricevat = $row["pricevat"];
    $totalprice = $row["totalprice"];
    $rptPO_status = $row["rptPO_status"];

}

ob_start();
?>

<div  lang="th">

        <h4  lang="th" align="center"> ใบสั่งซื้อ </h4>
       <h4 lang="th"> บริษัท สุมิตรเภสัช</h4>
         
                <table align="right" border="1" lang="th" >
                <tbody>
                    <tr>
                        <th>เลขที่ใบสั่งซื้อ</th>
                        <td><?=$rptPO_no?></td>
                    </tr>
                    <tr>
                        <th>วันที่</th>
                        <td><?=$rptPO_date?></td>
                    </tr>
                     </tbody>
                </table>
        <table  border="1" lang="th" style="width: 100%;">
         <tbody>
            <tr>
                <td style="width: 50%;">
                    <p>บริษัทผู้ขาย : <?=$cname?></p>
                    <br>
                    <p>ตัวแทน : <?=$rptPO_agent?></p>
                    <br>
                    <p>ที่อยู่  : <?=$rptPO_lo?></p>
                    <br>
                    <p>โทร  : <?=$rptPO_tel?></p>
                    <br>
                    <p>mail  : <?=$rptPO_mail?></p>
                </td>
                <td style="width: 50%;">
                    <p>เลขที่ใบกำกับภาษี  : <?=$rptPO_vatNo?></p>
                    <br>
                    <p>ที่อยู่จัดส่ง  : <?=$rptPO_losend?></p>
                    <br>
                    <p>กำหนดส่ง : <?=$rptPO_datesend?></p>


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
            <th>ราคา/หน่วย</th>
            <th>ส่วนลด</th>
            <th>จำนวนเงิน</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $sqlDe = "SELECT rpt_POdetail.*,product.pname FROM rpt_POdetail,product WHERE rpt_POdetail.productid = product.regno AND rpt_POdetail.rptPO_no = $poNO ORDER BY product.pname ASC";
            $c =0 ;
        if($result2 = mysqli_query($con,$sqlDe)){
            while ($rowD = $result2->fetch_array(1)) {
                ?>
                <tr>
                    <td><?=$c=$c+1?></td>
                    <td><?=$rowD["pname"]?></td>
                    <td align="center"><?=$rowD["remain"]?></td>
                    <td align="center"><?=$rowD["type"]?></td>
                    <td align="center"><?=$rowD["pricePerType"]?></td>
                    <td align="center"><?=$rowD["discount"]?></td>
                    <td align="center"><?=$rowD["priceall"]?></td>
                </tr>
                <?php
            }
        }
            ?>
             </tbody>
        </table>

    <table align="right " lang="th">

        <tbody>
        <tr>
            <th align="right">รวมเงิน : </th>
            <td><?=$pricesum?></td>
        </tr>
        <tr>
            <th align="right">ส่วนลด : </th>
            <td><?=$pricediscount?></td>
        </tr>
        <tr>
            <th align="right">หลังหักส่วนลด : </th>
            <td><?=$priceMIdicount?></td>
        </tr>
        <tr>
            <th align="right">ภาษีมูลค่าเพิม : </th>
            <td><?=$pricevat?></td>
        </tr>
        <tr>
            <th align="right">จำนวนเงินทั้งสิ้น : </th>
            <td><?=$totalprice?></td>
        </tr>
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

$mpdf->SetHeader('|<p lang="th">หน้า {PAGENO}/{nbpg}</p>|<p lang="th">ใบสั่งซื้อเลขที่ : '.$poNO.' </p>');
$mpdf->setFooter("<table   style='width: 100%;' lang='th' >
        <tbody>
        <tr>
            <td style='width: 50%;text-align: center;'>
                <p >ตัวแทน</p>
                <br>
                <p >...............................................................</p>
                <p >(	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;  &#160;	&#160;	&#160;	&#160;	&#160;	&#160; 	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;	&#160;)</p>
                <br>
                <p >วันที่ ........./........./..............</p>
            </td>
            <td style='width: 50%;text-align: center;'>
                <p>ในนาม บริษัท</p>
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
$mpdf->Output();
?>
