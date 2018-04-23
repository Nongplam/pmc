<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 */

$no = "";
if (isset($_GET["no"])){
    $no =  sprintf("%'.010d", $_GET["no"]);
}
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>รับสินค้าเข้าคลัง</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/lib/angular.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/lib/jquery-3.3.1.min.js"></script>
        <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <script src="js/lib/JsBarcode.code128.min.js"></script>

    </head>

    <body>
        <?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("24", $allowrule)){
            header("Location: auth.php");
        }
     ?>
        <div ng-app="reciveStockApp" ng-controller="reciveStockcontroller" class="ng-scope">
            <div class=" container">
                <br>
                <h3 align="center">รับสินค้าเข้าคลัง</h3>
                <hr>

                <div class="form-group row">
                    <label for="po_no" class="col-sm-2 col-form-label font-weight-bold text-right">รหัสใบสั่ง : </label>
                    <div class="col-sm-7">
                        <input name="po_no" ng-model="po_no" class="form-control" ng-focus="searchReciveStock()" ng-keyup="onEnter($event)" autofocus/>
                    </div>
                    <div class="col-sm-2">

                        <button class="btn btn-danger btn-xs" ng-click="searchReciveStock()"><span class="icon ion-search"></span></button>
                    </div>
                </div>


                <table class="table">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-2">#</th>
                            <th class="col-4">ชื่อ</th>
                            <th class="col-1 text-center">จำนวน</th>
                            <th class="col-2 text-center">หน่วย</th>
                            <th class="col-2 text-center">รับสินค้า</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="d-flex" ng-repeat=" PO in POs ">
                            <td class="col-2">{{$index + 1}}</td>
                            <td class="col-4">{{PO.pname}}</td>
                            <td class="col-1 text-center">{{PO.remain}}</td>
                            <td class="col-2 text-center">{{PO.type}}</td>
                            <td class="col-2 text-center"><button class="btn btn-primary" data-toggle="modal" data-target="#reciveModal" ng-click="reciveToStockModal(PO.rpt_POD_id,PO.rptPO_no,PO.cid,PO.pname,PO.productid,PO.remain,PO.type,PO.pricePerType)">รับ</button></td>
                        </tr>
                    </tbody>
                </table>




                <!--..................................modal addtpre start........................................-->
                <div class="modal fade" id="reciveModal" tabindex="-1" role="dialog" aria-labelledby="prestockModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="prestockModalLabel">เพิ่มสต็อค PO{{ponomodal}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                            </div>
                            <div class="modal-body">
                                <form id="modalform">
                                    <div class="container">
                                        <div class="row">
                                            <h5>ชื่อ :&nbsp; {{pnameonmodal}}</h5>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">จำนวน:</label>
                                        <div class="col-sm-5">
                                            <input type="number" min="0" step="1" ng-change="checkRemain()" class="form-control" ng-model="remain">
                                        </div>
                                        <label for="message-text" class="col-sm-1 col-form-label" ng-bind="typeonmodal"></label>
                                    </div>


                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">เลขที่ลอต :</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="lotno" ng-model="lotno" class="form-control ">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">ราคาต้นทุน :</label>
                                        <label for="message-text" class="col-sm-1 col-form-label" ng-bind="costprice"></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">ราคาฐาน : </label>
                                        <div class="col-sm-5">
                                            <input type="text" min="0" name="baseprice" ng-model="baseprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">ราคาบนกล่อง : </label>
                                        <div class="col-sm-5">
                                            <input type="text" min="0" name="boxprice" ng-model="boxprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">ราคาขายปลีก : </label>
                                        <div class="col-sm-5">
                                            <input type="text" min="0" name="retailprice" ng-model="retailprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">ราคาขายส่ง : </label>
                                        <div class="col-sm-5">
                                            <input type="text" min="0" name="wholesaleprice" ng-model="wholesaleprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">วันที่รับเข้า : </label>
                                        <div class="col-sm-5">
                                            <input type="date" name="receiveday" ng-model="receiveday" class="form-control">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">วันหมดอายุ : </label>
                                        <div class="col-sm-5">
                                            <input type="date" name="expireday" ng-model="expireday" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label font-weight-bold">BARCODE</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="barcode" id="barcode" ng-model="barcode" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-keyup="printbarcodeEnter($event)">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-3 col-form-label">พิมพ์ Barcode : </label>
                                        <div class="col-sm-5">
                                            <span>     
                                   <img id="barcodeimg"/>                         
                                    <button type="button" class="btn btn-primary" ng-click="openprintpage()">Print</button>
                                       </span>
                                        </div>
                                    </div>


                                    <input type="hidden" id="cid" name="cid" ng-model="cid">
                                    <input type="hidden" id="productid" name="productid" ng-model="productid">
                                    <input type="hidden" id="rpt_POD_id" name="rpt_POD_id" ng-model="rpt_POD_id">

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-success" ng-click="addToStock()">เพิ่มสต็อค</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--......................................endmodal...................................-->







            </div>
        </div>
        <script>
            var app = angular.module("reciveStockApp", []);

            app.controller("reciveStockcontroller", function($scope, $http) {
                /*$scope.po_no = '<?=sprintf("%'
                .010 d ", $no)?>';*/
                $scope.po_no = '<?php if (isset($_GET["no"])){
                                            echo $_GET["no"];
                                } ?>';
                $scope.receiveday = new Date();
                var poNo;
                var total;
                $scope.searchReciveStock = function() {
                    if ($scope.po_no == null) {
                        return false
                    }
                    poNo = $scope.po_no;
                    $http.post('php/getPOByPONo.php', {
                        'po_no': poNo
                    }).then(function(res) {
                        $scope.POs = res.data.records;
                    });
                };
                $scope.onEnter = function(event) {
                    if (event.keyCode == 13) {
                        $scope.searchReciveStock();
                    }
                    //console.log(event.keyCode)
                };
                $scope.checkRemain = function() {
                    if ($scope.remain > total || $scope.remain < 0 || $scope.remain == null) {
                        $scope.remain = total;
                    }
                };
                $scope.reciveToStockModal = function(rpt_POD_id, rptPO_no, cid, pname, productid, remain, type, pricePerType) {
                    $scope.ponomodal = rptPO_no;
                    $scope.pnameonmodal = pname;
                    $scope.remain = parseInt(remain);
                    total = parseInt(remain);
                    $scope.typeonmodal = type;
                    $scope.costprice = pricePerType;
                    $scope.cid = cid;
                    $scope.productid = productid;
                    $scope.rpt_POD_id = rpt_POD_id;


                };
                
                $scope.printbarcodeEnter = function(key){
                    if(key.keyCode == 13){
                        $scope.openprintpage();
                    }                    
                }
                
                $scope.openprintpage = function(){
                    var urlstr = 'printBarcode.php?codenumber=';
                    var code = $scope.barcode;
                    if(code != null){
                        window.open('printBarcode.php?codenumber='+code, '_blank');
                    }else{
                        sweetAlert("พิมพ์บารโคดผิดพลาด", "กรุณาใส่รหัสบาร์โคด", "warning");
                    }
                    
                };


                $scope.addToStock = function() {

                    if ($scope.remain == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่จำนวน", "warning");
                        return false;
                    }


                    if ($scope.lotno == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่เลขที่ลอต", "warning");
                        return false;
                    }

                    if ($scope.costprice == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาต้นทุน", "warning");
                        return false;
                    }
                    if ($scope.baseprice == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาฐาน", "warning");
                        return false;
                    }
                    if ($scope.boxprice == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาบนกล่อง", "warning");
                        return false;
                    }
                    if ($scope.retailprice == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาขายปลีก", "warning");
                        return false;
                    }
                    if ($scope.wholesaleprice == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาขายส่ง", "warning");
                        return false;
                    }
                    if ($scope.receiveday == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่วันที่รับเข้า", "warning");
                        return false;
                    }
                    if ($scope.expireday == null) {
                        sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่วันหมดอายุ", "warning");
                        return false;
                    } else {

                        $http.post('php/addToStock.php', {
                            'poNo': poNo,
                            'rpt_POD_id': $scope.rpt_POD_id,
                            'productid': $scope.productid,
                            'cid': $scope.cid,
                            'remain': $scope.remain,
                            'lotno': $scope.lotno,
                            'stocktype': $scope.typeonmodal,
                            'costprice': $scope.costprice,
                            'baseprice': $scope.baseprice,
                            'boxprice': $scope.boxprice,
                            'retailprice': $scope.retailprice,
                            'wholesaleprice': $scope.wholesaleprice,
                            'receiveday': $scope.receiveday,
                            'expireday': $scope.expireday,
                            'barcode': $scope.barcode

                        }).then(function(res) {
                            $('#reciveModal').modal('toggle');
                            $scope.remain = null;
                            $scope.lotno = null;

                            $scope.costprice = null;
                            $scope.baseprice = null;
                            $scope.boxprice = null;
                            $scope.retailprice = null;
                            $scope.wholesaleprice = null;
                            $scope.barcode = null;
                            $scope.receiveday = new Date();
                            $scope.expireday = new Date();
                            $scope.searchReciveStock();

                        });
                    }

                };    
            });

        </script>
        <script>
        $(document).ready(function(){
            $("#barcode").keyup(function(){
                var code = $("#barcode").val();
                //console.log(code);
                if(code != ""){
                    JsBarcode("#barcodeimg", code);
                }                
            });
        });
        </script>

        <script src="dist/sweetalert.min.js"></script>
    </body>

    </html>
