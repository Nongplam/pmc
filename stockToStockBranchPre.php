<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <script src="js/lib/popper.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>

<body>
<?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("19", $allowrule)){
            header("Location: auth.php");
        }
     ?>
<div class="container">
    <!--style="width:70%;"-->    

    <div ng-app="stockApp" ng-controller="stockcontroller" class="ng-scope">
        <br>
        <h3 align="center">จัดสินค้าเข้าคลังสาขา</h3>
        <hr>



        <div class="form-group row">
            <label for="branch" class="col-sm-2 col-form-label font-weight-bold text-right">เลือกสาขา : </label>
            <div class="col-sm-9">
                <select  id="branch" name="branch" ng-model="branch" class="form-control-plaintext custom-select" ng-init="selectBranch()"  ng-click="selectStockSubPreById()">
                    <option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>

                </select>
            </div>
        </div>










        <hr>



                    <table class="table " >
                        <thead>
                        <tr class="d-flex">
                            <th class="col-4">สินค้า</th>
                            <th class="col-2">เลขทะเบียน</th>
                            <th class="col-2">เลขล็อต</th>
                            <th class="col-2 text-center">จำนวน</th>
                            <th class="col-1 text-center">หน่วย</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="d-flex" ng-repeat="stockSubPre in stockSubPres">

                            <td class="col-4">{{stockSubPre.pname}}</td>
                            <td class="col-2">{{stockSubPre.realregno}}</td>
                            <td class="col-2">{{stockSubPre.lotno}}</td>
                            <td class="col-2 text-center">{{stockSubPre.bSP_qty}}</td>
                            <td class="col-1 text-center">{{stockSubPre.stocktype}}</td>
                            <td  class="col-1 text-center"> <button class="btn btn-danger btn-xs" ng-click="deletepreStock(stockSubPre.bSP_id)">ลบ</button></td>
                        </tr>
                        </tbody>
                    </table>



        <hr>
        <h3 align="right"><button class="btn btn-lg btn-success" ng-click="addTorptBranchStock()">สร้างใบนำส่งสินค้า</button></h3>
        <hr>

        <h3 align="center">สินค้าที่จะนำเข้าสต๊อกสาขา</h3>
        <br>
        <label>ค้นหา : </label>
        <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="SearchInput" placeholder="Search" />
        <br>
        <table class="table table-bordered table-responsive" ng-init="displayStock()" id="stockTable">
            <tbody>
            <tr>
                <th>สินค้า</th>
                <th>เลขทะเบียน</th>
                <th>บริษัท</th>
                <th>จำนวน</th>
                <th>เลขที่ลอต</th>
                <th>หน่วย</th>
                <th>วันที่รับเข้า</th>
                <th>วันหมดอายุ</th>
                <th>นำเข้า</th>

            </tr>
            <tr ng-repeat="stock in stocks | filter:SearchInput">
                <td>{{stock.pname}}</td>
                <td>{{stock.productid}}</td>
                <td>{{stock.cname}}</td>
                <td>{{stock.remain}}</td>
                <td>{{stock.lotno}}</td>
                <td>{{stock.stocktype}}</td>
                <td>{{stock.receiveday | date:'dd/MM/yyyy'}}</td>
                <td>{{stock.expireday | date:'dd/MM/yyyy'}}</td>

                <td><button class="btn btn-info btn-xs" type="button" ng-click="setpreModal(stock.sid,stock.lotno,stock.pname,stock.stocktype,stock.remain)" data-toggle="modal" data-target="#prestockModal">เตรียม</button></td>
            </tr>
            </tbody>
        </table>
        <hr>


        <!--..................................modal addtoPOS start........................................-->
        <div class="modal fade" id="prestockModal" tabindex="-1" role="dialog" aria-labelledby="prestockModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prestockModalLabel">เพิ่มสินค้า</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modalform">
                            <div class="container">
                                <div class="row">
                                    <h5>เลขล็อตที่ :&nbsp; {{lotonmodal}} </h5>
                                    <h5 id="lotnumber"></h5>
                                </div>
                                <div class="row">
                                    <h5>ชื่อ :&nbsp; {{pnameonmodal}}</h5>
                                    <h5 id="productname"></h5>
                                </div>
                            </div>
                            <!--<label id="productname">ชื่อ : </label>-->
                            <!--<label id="lotnumber">เลขล็อตที่ : </label>-->
                            <div class="form-group row">
                                <label for="message-text" class="col-sm-2 col-form-label">จำนวน:</label>
                                <div class="col-sm-5">
                                    <input type="number" min="1" step="1" class="form-control" ng-model="prestockqtyonmodal">
                                </div>
                                <label for="message-text" class="col-sm-1 col-form-label" ng-bind="typeonmodal"></label>
                                <input type="hidden" id="stocknumber" ng-model="stocknumber">
                                <input type="hidden" id="stockremain" ng-model="stockremain">
                            </div>



                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-success" ng-click="addtoprepare()" data-dismiss="modal">เพิ่มรายการ</button>
                    </div>
                </div>
            </div>
        </div>
        <!--......................................endmodal...................................-->
    </div>
</div>
<script>
    var app = angular.module("stockApp", []);

    app.controller("stockcontroller", function($scope, $http) {
        //ดึงข้อมูล stock มาแสดง
        $scope.prestockqtyonmodal = 1;
        $scope.toshelfmodal;
        $scope.displayStock = function() {
            $http.get("php/stockSelect.php").then(function(response) {
                $scope.stocks = response.data.records;
            });
        }
        $scope.selectBranch = function(){

            $http.get('php/subbranchSelect.php').then( function(response){


                $scope.branchs = response.data.records;
            });

        }

        $scope.selectStockSubPreById = function(){
            if ($scope.branch == null){
                return false;
            }

            $http.post('php/selectStockSubPreById.php',{
                'subid':$scope.branch

            }).then(function(response){
                $scope.stockSubPres = response.data.records;

            });

        }



        $scope.setpreModal = function(sid, lotno, pname, type,remain) {
            $scope.sidonmodal = sid;
            $scope.lotonmodal = lotno;
            $scope.pnameonmodal = pname;
            $scope.typeonmodal = type;
            $scope.remain = remain;
        }

        $scope.addtoprepare = function() {
            var stockid = $scope.sidonmodal;
            var qty = $scope.prestockqtyonmodal;
            var subid = $scope.branch;
            
            if(qty > $scope.remain ){
                sweetAlert("คำเตือน", "ห้ามใส่เกินจำนวนที่มี", "warning");
                return;
            }

            if ($scope.branch == null){
                sweetAlert("คำเตือน", "กรุณาเลือกสาขา", "warning");
                return false;
            }
            $http.post("php/addToBranchStockPrepare.php", {
                'stockid': stockid,
                'qty': qty,
                'subid':subid
            }).then(function(data) {
                swal("บันทึกข้อมูลเสร็จสิ้น", "บันทึกข้อมูลแล้ว", "success");
                $scope.sidonmodal = null;
                $scope.prestockqtyonmodal = 1;
                $scope.selectStockSubPreById();
            });

        }
        $scope.deletepreStock = function(bSP_id) {


            swal({
                title: "คุณแน่ใจหรือไม่",
                text: "ยืนยันการลบข้อมูล",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((data) => {
                    if (data) {
                        $http.post("php/deleteBranchStockPre.php", {
                            'bSP_id': bSP_id
                        }).then(function(data) {
                            swal("ลบข้อมูลเสร็จสิ้น", "ลบข้อมูลแล้ว", "success");
                            $scope.selectStockSubPreById();
                        });
                    }
                });

        }
        $scope.addTorptBranchStock = function() {
            if ($scope.branch == null){
                sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาเลือกสาขา", "warning");
                return false;
            }

            $http.post("php/addTorptBranchStock.php", {
                'subid': $scope.branch
            }).then(function(data) {
                swal("บันทึกข้อมูลเสร็จสิ้น", "บันทึกข้อมูลแล้ว", "success");
                $scope.selectStockSubPreById();
                $scope.displayStock();
            });
        }

        $scope.logtest = function() {
            alert("Work!!");
        }
    });

</script>
<script>


</script>
<script src="dist/sweetalert.min.js"></script>

</body>
