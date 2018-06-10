<html>

<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <style>
        .modal-lg {
            max-width: 70%;
        }

    </style>
</head>

<body>
    <?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("25", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div ng-app="importhistoryApp" ng-controller="importhistorymainController" class="ng-scope">
        <div class="container">
            <div class="d-flex justify-content-center">
                <h3>ประวัติการนำเข้าสินค้า</h3>
            </div>

            <div>
                <div class="form-group row">

                    <label class="col-sm-1 col-form-label font-weight-bold text-right " for="branch"> สาขา :</label>
                    <select id="branch" name="branch" ng-model="branch" class="form-control col-sm-3 mr-2" ng-init="selectBranch()">
                <option ng-repeat="branch in branchs" value="{{branch.id}}" selected>{{branch.name}}</option>
                </select>

                    <label class="col-sm-2 col-form-label font-weight-bold text-right " for="date1"> เลือกช่วงวัน :</label>
                    <input type="date" name="date1" id="date1" ng-model="date1" class="form-control col-sm-2 mr-2">
                    <label class="col col-form-label font-weight-bold text-right " for="date2">ถึง</label>
                    <input type="date" name="date2" id="date2" ng-model="date2" class="form-control col-sm-2 mr-2">
                    <input type="submit" name="" ng-click="getimportHistory()" class="btn btn-success col-sm-1" value="ตกลง" style="width: 117px;">
                    <!--<input type="submit" name="" ng-click="formateDate(date1)" class="btn btn-success col-sm-1" value="ตกลง" style="width: 117px;">-->
                </div>
            </div>
        </div>
        <div class="container col-9" ng-show="showhistorytable">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>เลขที่สต๊อก</th>
                        <th>ชื่อสินค้า</th>
                        <th>เลขที่ใบสั่งซื้อ</th>
                        <th>เลขล็อต</th>
                        <th>คู่ค้า</th>
                        <th>จำนวนนำเข้า</th>
                        <th>จำนวนคงเหลือ</th>
                        <th>หน่วย</th>
                        <!--<th>ราคาทุนต่อหน่วย</th>
                        <th>ราคาขายต่อหน่วย</th>
                        <th>กำไรต่อหน่วย</th>-->
                        <th>วันที่รับเข้า</th>
                        <th>เวลาที่บันทึก</th>
                        <!--<th>ติดตามสิ้นค้า</th>-->
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in historys">
                        <td>{{item.sid}}</td>
                        <td>{{item.pname}}</td>
                        <td>{{checkPO(item.PO_No)}}</td>
                        <td>{{item.lotno}}</td>
                        <td>{{item.cname}}</td>
                        <td>{{item.remainfull}}</td>
                        <td>{{item.remain}}</td>
                        <td>{{item.stocktype}}</td>
                        <!--<td>{{item.costprice}}</td>
                        <td>{{item.retailprice}}</td>
                        <td>{{item.retailprice-item.costprice}}</td>-->
                        <td>{{item.receiveday}}</td>
                        <td>{{item.logdatetime}}</td>
                        <!--<td><button class="btn btn-info" ng-click="getstockTrail(item.sid,item.pname)">✓</button></td>-->
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>

        <!--<div class="container col-9" ng-show="showtrailtable">
            <div class="d-flex justify-content-start">
                <h4>สินค้ารหัส {{trailid}} : {{trailname}} ถูกส่งไปที่</h4>
            </div>
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>เลขที่สต๊อกในสาขา</th>
                        <th>ชื่อสินค้า</th>
                        <th>จำนวนนำเข้า</th>
                        <th>จำนวนคงเหลือ</th>
                        <th>หน่วย</th>
                        <th>ราคาขายหน้าร้าน</th>
                        <th>ชื่อ - สกุล ผู้รับสินค้า</th>
                        <th>อยู่ที่สาขา</th>
                        <th>วันที่รับเข้า</th>
                        <th>วันที่บันทึกสินค้า</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in trails">
                        <td>{{item.sid}}</td>
                        <td>{{item.pname}}</td>
                        <td>{{item.remainfull}}</td>
                        <td>{{item.remain}}</td>
                        <td>{{item.stocktype}}</td>
                        <td>{{item.retailprice}}</td>
                        <td>{{item.fname +' '+item.lname}}</td>
                        <td>{{item.branchname}}</td>
                        <td>{{item.receiveday}}</td>
                        <td>{{item.logdatetime}}</td>
                    </tr>
                </tbody>
            </table>
        </div>-->
        <!--------------------------------trailmodalStart----------------------------------->
        <div role="dialog" tabindex="-1" class="modal fade show" id="trailmodal">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">สินค้ารหัส {{trailid}} : {{trailname}} ถูกส่งไปที่</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>สาขา</th>
                                    <th>เลขที่สต๊อกในสาขา</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>จำนวนที่ส่งไป</th>
                                    <!--<th>จำนวนคงเหลือ</th>-->
                                    <th>หน่วย</th>
                                    <!--<th>ราคาขายหน้าร้าน</th>-->
                                    <th>ชื่อ - สกุล ผู้รับสินค้า</th>
                                    <th>วันที่รับเข้า</th>
                                    <th>วันที่บันทึกสินค้า</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in trails">
                                    <td>{{item.branchname}}</td>
                                    <td>{{item.sid}}</td>
                                    <td>{{item.pname}}</td>
                                    <td>{{item.remainfull}}</td>
                                    <!--<td>{{item.remain}}</td>-->
                                    <td>{{item.stocktype}}</td>
                                    <!--<td>{{item.retailprice}}</td>-->
                                    <td>{{item.fname +' '+item.lname}}</td>
                                    <td>{{item.receiveday}}</td>
                                    <td>{{item.logdatetime}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" type="button" data-dismiss="modal" ng-click="resetreturnitem()">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------------trailmodalStart----------------------------------->
    </div>
    <script>
        var app = angular.module("importhistoryApp", []);
        app.controller("importhistorymainController", function($scope, $http, $window) {
            $scope.date1 = new Date();
            $scope.date1.setHours(0);
            $scope.date1.setMinutes(0);
            $scope.date2 = new Date();
            $scope.date2.setHours(23);
            $scope.date2.setMinutes(59);
            $scope.showhistorytable = false;
            $scope.showtrailtable = false;

            $scope.selectBranch = function() {
                $http.get('php/subbranchSelect.php').then(function(response) {
                    $scope.branchs = response.data.records;
                    $scope.branch = $scope.branchs[0]['id'];
                });
            };

            $scope.getimportHistory = function() {
                var date1 = $scope.formateDate($scope.date1);
                var date2 = $scope.formateDate($scope.date2);
                var branch = $scope.branch;
                if (branch == undefined) {
                    swal("ยังไม่เลือกสาขา!", "กรุณาเลือกสาขาที่ต้องการดูข้อมูล", "warning");
                } else {
                    $scope.showhistorytable = true;
                    $http.get('php/getreportimportHistory.php?branch=' + branch + '&date1=' + date1 + '&date2=' + date2).then(function(response) {
                        $scope.historys = response.data.records;
                        var i = 0
                        for (i = 0; i < $scope.historys.length; i++) {
                            $scope.historys[i]['receiveday'] = $scope.formatmonth($scope.historys[i]['receiveday']);
                            $scope.historys[i]['logdatetime'] = $scope.formatmonthtype2($scope.historys[i]['logdatetime']);
                        }
                    });
                }
            }

            $scope.getstockTrail = function(trailid, pname) {

                $http.get('php/getstockTrail.php?trailid=' + trailid).then(function(response) {
                    $scope.trails = response.data.records;
                    var j = 0
                    for (j = 0; j < $scope.trails.length; j++) {
                        $scope.trails[j]['receiveday'] = $scope.formatmonth($scope.trails[j]['receiveday']);
                        $scope.trails[j]['logdatetime'] = $scope.formatmonthtype2($scope.trails[j]['logdatetime']);
                    }
                    if ($scope.trails.length >= 1) {
                        $scope.trailid = trailid;
                        $scope.trailname = pname;
                        $scope.showtrailtable = false;
                        var temp = $("#trailmodal");
                        temp.modal("show");
                        /*var trailmodal = angular.element("#trailmodal");
                        console.log(trailmodal);*/
                    } else {
                        $scope.showtrailtable = false;
                        swal("ไม่สามารถติดตามสินค้าได้!", "สินค้าไม่เคยถูกจัดส่งไปที่สาขาย่อย", "warning");
                    }
                });

            }

            $scope.checkPO = function(po) {
                if (po == null) {
                    return 'ไม่มีใบสั่งสินค้า'
                    ว
                } else {
                    return po;
                }
            }

            $scope.formateDate = function(date) {
                var m = parseInt(date.getMonth()) + 1;
                var newdate = date.getFullYear() + '-' + m + '-' + date.getDate();
                return newdate;
            }

            $scope.formatmonth = function(date) {
                var datetemp = date;
                var realdate = new Date(datetemp);
                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var newdate = realdate.getFullYear() + '-' + months[realdate.getMonth()] + '-' + realdate.getDate();
                return newdate;
            }
            $scope.formatmonthtype2 = function(date) {
                var datetemp = date;
                var realdate = new Date(datetemp);
                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var newdate = realdate.getFullYear() + '-' + months[realdate.getMonth()] + '-' + realdate.getDate() + ' ' + realdate.getHours() + ':' + realdate.getMinutes();
                return newdate;
            }
        });

    </script>
</body>
<script src="dist/sweetalert.min.js"></script>

</html>
