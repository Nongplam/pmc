<!DOCTYPE html>
<?php
session_start();
include "php/connectDB.php";
$subbranchid = $_SESSION["subbranchid"];
$stm1="select max(rptid) as rptid from rpt_stocktoshelf where rpt_stocktoshelf.subbranchid = '$subbranchid'";
$result1=mysqli_query($con, $stm1);
$rs1 = $result1->fetch_array(MYSQLI_ASSOC);
$max = $rs1["rptid"];

$stm2="select rpt_stocktoshelf.* from rpt_stocktoshelf where rpt_stocktoshelf.subbranchid = '$subbranchid' and rpt_stocktoshelf.rptid = '$max'";
$result = mysqli_query($con, $stm2);
$rs = $result->fetch_array(MYSQLI_ASSOC);
$rptno = $rs["rptno"];
$rptdate = $rs["rptdate"];
$userno = $rs["userid"];

?>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>withdrawtoshelfrecipe</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <body>
        <div class="container">
            <div class="row d-flex justify-content-center"><label style="font-size:24px;">ใบเบิกสินค้าเข้าชั้นวาง</label></div>
            <div class="row">
                <div class="col"><label class="col-form-label">Logo</label></div>
                <div class="col d-flex justify-content-center text-center"><label class="col-form-label">
                <?php 
                    $stm4 = "select * from subbranch where subbranch.id = '$subbranchid'";
                    $result4 = mysqli_query($con, $stm4);
                    $row4 = $result4->fetch_array(MYSQLI_ASSOC);
                echo $row4["name"];
                echo "<br>";
                echo $row4["info"];
                
                echo "<br>";
                echo $row4["tel"];
                ?>
                
                </label></div>
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="border"><b>เลขที่ใบ</b></td>
                                    <td class="border">
                                        <?php echo $rptno; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border"><b>วันที่ออก</b></td>
                                    <td class="border">
                                        <?php 
                                        for($i = 0;$i<10;$i++){
                                            echo $rptdate[$i];
                                        }
                                      ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th>เลขทะเบียน</th>
                                <th>เลขล็อต</th>
                                <th>ชั้นวาง</th>
                                <th>จำนวน</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $stm3="select product.pname,stock.productid,stock.lotno,shelf.shelfno,rpt_stocktoshelfdetail.qty,shelf.shelfinfo from stock,product,shelf,rpt_stocktoshelfdetail where rpt_stocktoshelfdetail.rptid = '$max' and rpt_stocktoshelfdetail.stockid = stock.sid and rpt_stocktoshelfdetail.toshelfno = shelf.shelfno and rpt_stocktoshelfdetail.subbranchid = '$subbranchid' and product.regno = stock.productid";
                        $result3 = mysqli_query($con, $stm3);
                        while ($row = $result3->fetch_array(MYSQLI_ASSOC)){
                            
                        
                        ?>
                            <tr>
                                <td>
                                    <?php echo $row["pname"] ?><br></td>
                                <td>
                                    <?php echo $row["productid"] ?><br></td>
                                <td>
                                    <?php echo $row["lotno"] ?><br></td>
                                <td>
                                    <?php echo $row["shelfno"] ?><br></td>
                                <td>
                                    <?php echo $row["qty"] ?>
                                </td>
                                <td>
                                    <?php echo $row["shelfinfo"] ?><br></td>
                            </tr>
                            <?php } ?>
                            <!--<tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td>จำนวนทั้งหมด<br></td>
                            <td>1</td>
                            <td><br></td>
                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col col-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">ผู้เบิก</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">...................................................</td>
                                </tr>
                                <tr>
                                    <td class="text-center">( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col col-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">ผู้ดูแล</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">...................................................<br></td>
                                </tr>
                                <tr>
                                    <td class="text-center">( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )<br></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h6 class="text-right">
                <?php echo $userno; ?>
            </h6>
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        </div>
    </body>

    </html>
