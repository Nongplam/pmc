<html>

<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <style>
        .container {
            max-width: 95%;
        }

    </style>
</head>

<body>
    <?php 
    ob_start();
    include 'mainbartest.php';    
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);    
        if (!in_array("38", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div ng-app="createpromotionApp" ng-controller="createpromotionmainController" class="ng-scope">
        <div>
            <div class="d-flex justify-content-center mb-2">
                <h3>สร้างโปรโมชัน</h3>
            </div>
            <div class="container" style="width:110%;">
                <div class="row mb-2">
                    <div class="col" ng-init="selectBranch()"><label>เลือกสาขา</label>
                        <select class="custom-select mb-1" ng-model="branch" ng-change="getstockinbranch()">
                        <option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
                       
                       </select>
                        <hr class="mb-1 mt-1">
                        <div class="row mb-1">
                            <div class="col d-flex justify-content-center">
                                <span class="mr-sm-1 align-self-center">เลือกสินค้าที่ต้องการจัดโปรโมชัน</span>
                                <!--<input type="text" class="input-group-text" />-->
                            </div>
                            <div class="col d-flex justify-content-center">
                                <div class="input-group mb-sm-1 align-self-center">
                                    <div class="input-group-prepend"><span class="input-group-text">ค้นหา</span></div><input class="form-control" type="text" ng-model="stockfiller" />

                                </div>
                            </div>

                        </div>

                        <div style="height:400px; overflow-y: scroll;">
                            <table class="table table-bordered">
                                <thead class="table-info">
                                    <tr>
                                        <th>เลขสต๊อก</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>หน่วย</th>
                                        <th>คงเหลือ</th>
                                        <th>ต้นทุน</th>
                                        <th>ราคาปลีก</th>
                                        <th>วันหมดอายุ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="stock in stocks | filter:stockfiller">
                                        <td>{{stock.sid}}</td>
                                        <td>{{stock.pname}}</td>
                                        <td>{{stock.stocktype}}</td>
                                        <td>{{stock.remain}}</td>
                                        <td>{{stock.costprice}}</td>
                                        <td>{{stock.retailprice}}</td>
                                        <td style="width:15%;">{{stock.expireday}}</td>
                                        <td> <button class="btn btn-primary" ng-click="sendtoprePromotion(stock.sid)"> -> </button> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--<div class="col d-flex justify-content-center align-self-center col-1" style="height:40px;">
                        <p>--&gt;</p>
                    </div>-->
                    <div class="col-4">
                        <div class="row">
                            <div class="col-9 d-flex justify-content-start align-self-center"><label style="font-size: 90%;">รายการของจัดชุดโปรโมชันของสาขา {{branchname}} </label></div>
                            <div class="col d-flex justify-content-end">
                                <button class="btn btn-danger" ng-click="clearprePromotion()">ลบ</button>
                            </div>

                        </div>
                        <div class="">
                            <table class="table table-bordered mb-2">

                                <thead class="table-info">
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>เลขสต๊อก</th>
                                        <th>ชื่อสินค้า</th>
                                        <th style="width:30%;">จำนวน</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr ng-repeat="item in prepromos">
                                        <!--<td>{{$index+1}}</td>-->
                                        <td>{{item.stockid}}</td>
                                        <td>{{item.pname}}</td>
                                        <td>
                                            <center>{{item.qty}} {{item.stocktype}}</center>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div ng-show="isadd">
                            <div class="row mb-2">
                                <div class="col">
                                    <label>ชื่อโปรโมชัน</label>
                                    <div class="input-group">
                                        <input type="text" ng-model="promoname" class="form-control" />
                                    </div>
                                </div>
                                <div class="col col-4 ">
                                    <label>รหัสส่วนลด</label>
                                    <div class="input-group">
                                        <input type="text" ng-model="promocode" class="form-control" />
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label>วันเริ่มโปรโมชัน</label>
                                    <div class="input-group">
                                        <input type="date" ng-model="date1" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>วันหมดโปรโมชัน</label>
                                    <div class="input-group">
                                        <input type="date" ng-model="date2" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-4">
                                    <label>ราคาต่อชุด</label>
                                    <div class="input-group">
                                        <input type="text" ng-model="promoprice" class="form-control" />
                                    </div>
                                </div>
                                <div class="col align-self-end d-flex justify-content-end">
                                    <button class="btn btn-success" ng-click="checkoutPromotion()">ตกลง</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col">
                        <hr>
                        <div class="row">
                            <div class="col-3 align-self-center">
                                <label>รายการโปรโมชันของสาขา {{bottomsubbranch}}</label>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">ค้นหา</span></div><input class="form-control" type="text" ng-model="promotionfiller" />

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <table class="table table-bordered">
                                <thead class="table-info">
                                    <tr>
                                        <th>รหัสส่วนลด</th>
                                        <th>ชื่อโปรโมชัน</th>
                                        <th>ราคาต่อชุด</th>
                                        <th>มูลค่าส่วนลด</th>
                                        <th>ราคาเต็ม</th>
                                        <th>วันเริ่มโปรโมชัน</th>
                                        <th>วันหมดโปรโมชัน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="pro in promotions | filter: promotionfiller">
                                        <td>{{pro.promotioncode}}</td>
                                        <td>{{pro.promotionname}}</td>
                                        <td>{{pro.priceperpack}}</td>
                                        <td>{{pro.discount}}</td>
                                        <td>{{pro.fullprice}}</td>
                                        <td>{{pro.startdate}}</td>
                                        <td>{{pro.expiredate}}</td>
                                        <td><button class="btn btn-info" ng-click="getpromotiondetail(pro.stockidwithqty)">เพิ่มเติม</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-------------------------------Modal detail start--------------------------->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">รายละเอียดโปรโมชัน</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                    </div>
                    <div class="modal-body">

                        <div>
                            <table class="table">
                                <thead class="table-info">
                                    <tr>
                                        <th>ชื่อสินค้า</th>
                                        <th>จำนวน</th>
                                        <th>หน่วย</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in details">
                                        <td>{{item.pname}}</td>
                                        <td class="text-right">{{item.qty}}</td>
                                        <td>{{item.type}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    var app = angular.module("createpromotionApp", []);
    app.controller("createpromotionmainController", function($scope, $http, $window) {

        $scope.date1 = new Date();
        $scope.date2 = new Date();
        $scope.isadd = true;
        $scope.selectBranch = function() {
            $http.get('php/subbranchSelect.php').then(function(response) {
                $scope.branchs = response.data.records;
                $scope.branch = $scope.branchs[0]['id'];
                $scope.getstockinbranch();
            });
        };

        $scope.getstockinbranch = function() {
            $http.post("php/getstockbyBranch.php", {
                'branch': $scope.branch
            }).then(function(response) {
                $scope.stocks = response.data.records;
                $scope.branchname = null;
                $scope.getprePromotion();
                $scope.bottomsubbranch = $scope.stocks[0]['name'];
                $scope.getpromotion();
                $scope.resetnewpromo();

            });
        }

        $scope.getprePromotion = function() {
            $http.post("php/getprePromotion.php", {
                'branch': $scope.branch
            }).then(function(response) {
                $scope.prepromos = response.data.records;
                if ($scope.prepromos.length > 0) {
                    $scope.branchname = $scope.prepromos[0]['name'];
                }


            });
        }

        $scope.sendtoprePromotion = function(stock) {
            $http.post("php/inserttoprePromotion.php", {
                'branch': $scope.branch,
                'stock': stock
            }).then(function(response) {
                $scope.getprePromotion();
            });
        }

        $scope.clearprePromotion = function() {
            $http.post("php/deleteprePromotion.php", {
                'branch': $scope.branch
            }).then(function(response) {
                $scope.getstockinbranch();
                $scope.getprePromotion();
            });
        }

        $scope.getpromotion = function() {
            $http.post("php/getpromotionbyBranch.php", {
                'branch': $scope.branch
            }).then(function(response) {
                $scope.promotions = response.data.records;
            });
        }


        $scope.getpromotiondetail = function(detail) {
            $("#detailModal").modal('toggle');
            $http.post("php/getpromotiondetail.php", {
                'detail': detail
            }).then(function(response) {
                //console.log(response.data);
                $scope.details = response.data.records;
            });

        }

        $scope.checkoutPromotion = function() {
            if ($scope.promoname == null || $scope.promoprice == null || $scope.promocode == null) {
                alert("กรุณาใส่ข้อมูลให้ครบ");
            } else if (isNaN($scope.promoprice)) {
                alert("กรุณาใส่จำนวนให้ถูกต้อง");
            } else {
                console.log($scope.promoname);
                console.log($scope.promoprice);
                console.log($scope.date1);
                console.log($scope.date2);
                console.log($scope.promocode);
                $scope.resetnewpromo();


            }

        }

        $scope.resetnewpromo = function() {
            $scope.promoname = null;
            $scope.promoprice = null;
            $scope.date1 = new Date();
            $scope.date2 = new Date();
            $scope.promocode = null;
        }

        $scope.logtest = function() {
            alert($scope.branch);


        }
    });

</script>

</html>
