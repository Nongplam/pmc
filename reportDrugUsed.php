<?php
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_month_arr=array(
    "0"=>"",
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน", 
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"                 
);
function thai_date($time){
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return="วัน";//.$thai_day_arr[date("w",$time)];
    $thai_date_return.= "ที่ ".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " ".(intval(date("Yํ",$time))+543);
    //$thai_date_return.= "  ".date("H:i",$time)." น.";
    return $thai_date_return;
}
    $eng_date=time();

?>
    <html>

    <head>
        <meta charset="utf-8">
        <title>PcmStore</title>
        <script src="js/lib/angular.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/lib/jquery-3.3.1.min.js"></script>
        <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
        <!--<style>
        .modal-lg {
            max-width: 70%;
        }

    </style>-->
    </head>

    <body>
        <?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("27", $allowrule)){
            header("Location: auth.php");
        }
     ?>
        <div ng-app="drugusedApp" ng-controller="drugusedmainController" class="ng-scope">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <h3>ปริมาณการใช้ยาแต่ละสาขา </h3>
                </div>
                <div class="d-flex justify-content-center">
                    <h3>ณ
                        <?php echo thai_date($eng_date); ?>
                    </h3>
                </div>
                <br>
                <!--<div class="form-group row d-flex justify-content-center">

                    <label class="col-sm-1 col-form-label font-weight-bold text-right " for="branch"> สาขา :</label>
                    <select id="branch" name="branch" ng-model="branch" class="form-control col-sm-3 mr-2" ng-init="selectBranch()">
                <option ng-repeat="branch in branchs" value="{{branch.id}}" selected>{{branch.name}}</option>
                </select>

                    <label class="col-sm-2 col-form-label font-weight-bold text-right " for="date1"> เลือกช่วงวัน :</label>
                    <input type="date" name="date1" id="date1" ng-model="date1" class="form-control col-sm-2 mr-2">
                    <label class="col col-form-label font-weight-bold text-right " for="date2">ถึง</label>
                    <input type="date" name="date2" id="date2" ng-model="date2" class="form-control col-sm-2 mr-2">
                    <input type="submit" name="" ng-click="getimportHistory()" class="btn btn-success col-sm-1" value="ตกลง" style="width: 117px;">
                    <input type="submit" name="" ng-click="formateDate(date1)" class="btn btn-success col-sm-1" value="ตกลง" style="width: 117px;">
                </div>-->
                <div class="container col-12" ng-init="getusedperday()">
                    <div class="d-flex justify-content-end">
                        <!--<h3>Print</h3>-->
                        <button type="button" class="btn btn-default">
          <span><img src="svg/si-glyph-print.svg" height="15" width="15"/></span> Print
                        </button>
                    </div>
                    <br>
                    <table class="table table table-bordered">
                        <thead class="table-info">
                            <tr>
                                <th>สาขา</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>หน่วย</th>
                                <th>คลังใหญ่ (ชิ้น)</th>
                                <th>คงเหลือสาขา (ชิ้น)</th>
                                <th>เฉลี่ยขายต่อวัน</th>
                                <th ng-click="orderbyemptyindayToggle()">สินค้าจะหมดใน (วัน)<span><img src="svg/si-glyph-disc-play-2.svg" height="15" width="15"/></span>
                                </th>
                                <th style="width:15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in usedperdays | orderBy:['name',orderbyemptyinday]">
                                <td>{{item.name}}</td>
                                <td>{{item.mainpid}}</td>
                                <td>{{item.pname}}</td>
                                <td>{{item.mainstocktype}}</td>
                                <td>{{item.mainbranchremain}}</td>
                                <td>{{checkbranchEmpty(item.branchremain)}}</td>
                                <td>{{item.aveusedperday}}</td>
                                <td>{{checkbranchEmpty(item.emptyinday)}}</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" ng-model="sendqtyintable[$index]" ng-keyup="setmodalbyEnter($event,item.pname,sendqtyintable[$index],item.name,item.mainstocktype,item.mainbranchremain)" class="form-control" placeholder="จำนวน">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" ng-click="setsenditemmodal(item.pname,sendqtyintable[$index],item.name,item.mainstocktype,item.mainbranchremain)">จัดส่ง</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!------------------------------------ Modal ------------------------------------>
            <div class="modal fade" id="sendtouserModal" tabindex="-1" role="dialog" aria-labelledby="sendtouserModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-light" id="exampleModalLongTitle">ส่งสินค้า</h5>
                            <button type="button" class="close" ng-click="resetmodal()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                        </div>
                        <div class="modal-body" ng-init="getalluser()">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">เลือกผู้รับผิดชอบ :</label>
                                    <select id="reciveuserid" name="reciveuserid" ng-model="reciveuserid" class="form-control col-sm mr-2" ng-init="selectBranch()">
                <option ng-repeat="user in users | orderBy:'rolethai'" value="{{user.id}}">{{user.fname}} {{user.lname}} หน้าที่ : {{user.rolethai}}</option>
                </select>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">ข้อความ :</label>
                                    <textarea class="form-control" id="message-text" ng-model="textonsendmodal"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" ng-click="resetmodal()" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" ng-click="sendtouser();resetmodal()" data-dismiss="modal">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------- endModal ---------------------------------->
        </div>
        <script>
            var app = angular.module("drugusedApp", []);
            app.controller("drugusedmainController", function($scope, $http, $window) {

                $scope.orderbyemptyinday = 'emptyinday';
                $scope.sendqtyintable = [];

                $scope.getusedperday = function() {
                    $http.get('php/getReportDrugUsed.php').then(function(response) {
                        $scope.usedperdays = response.data.records;
                        for (var i = 0; i < $scope.usedperdays.length; i++) {
                            $scope.usedperdays[i]['emptyinday'] = $scope.usedperdays[i]['branchremain'] / $scope.usedperdays[i]['aveusedperday'];
                            $scope.usedperdays[i]['emptyinday'] = parseFloat($scope.usedperdays[i]['emptyinday'].toFixed(2));
                        }
                    });
                }

                $scope.setsenditemmodal = function(pname, qty, branchname, stocktype, mainbranchremain) {
                    if (qty == undefined) {
                        swal("กรุณาใส่จำนวนสินค้าที่ต้องการส่ง!", "", "warning");
                    } else {
                        if (parseInt(qty) > parseInt(mainbranchremain)) {
                            swal("ท่านกำลังส่งสินค้ามากกว่าที่มีในสาขาใหญ่!", "", "warning");
                            $scope.pnameonmodal = pname;
                            $scope.qtyonmodal = qty;
                            $scope.branchnameonmodal = branchname;
                            $scope.stocktypeonmodal = stocktype;
                            $scope.textonsendmodal = 'ส่ง ' + pname + ' จำนวน ' + qty + ' ' + stocktype + ' ' + 'ไปที่สาขา ' + branchname;
                            $('#sendtouserModal').modal('show')
                        } else {
                            $scope.pnameonmodal = pname;
                            $scope.qtyonmodal = qty;
                            $scope.branchnameonmodal = branchname;
                            $scope.stocktypeonmodal = stocktype;
                            $scope.textonsendmodal = 'ส่ง ' + pname + ' จำนวน ' + qty + ' ' + stocktype + ' ' + 'ไปที่สาขา ' + branchname;
                            $('#sendtouserModal').modal('show')
                        }
                    }
                    $scope.sendqtyintable = [];
                }

                $scope.logtest = function() {
                    console.log($scope.reciveuserid);
                }

                $scope.orderbyemptyindayToggle = function() {
                    if ($scope.orderbyemptyinday == 'emptyinday') {
                        $scope.orderbyemptyinday = '-emptyinday';
                    } else {
                        $scope.orderbyemptyinday = 'emptyinday';
                    }

                }
                $scope.checkbranchEmpty = function(remain) {
                    if (remain < 1) {
                        return 'สินค้าหมด';
                    } else {
                        return remain;
                    }
                }

                $scope.getalluser = function() {
                    $http.get('php/getalluserinmainBranch.php').then(function(response) {
                        $scope.users = response.data.records;
                        $scope.reciveuserid = $scope.users[0]['id'];
                    })
                }

                $scope.setmodalbyEnter = function(e, pname, qty, branchname, stocktype, mainbranchremain) {
                    if (e.keyCode == 13) {
                        $scope.setsenditemmodal(pname, qty, branchname, stocktype, mainbranchremain);
                    }
                }

                $scope.resetmodal = function() {
                    $scope.textonsendmodal = null;
                    //$scope.reciveuserid = $scope.users[0]['id'];
                }

                $scope.sendtouser = function() {
                    $http.post("php/insertsendtobranchTodo.php", {
                        'message': $scope.textonsendmodal,
                        'userrecive': $scope.reciveuserid
                    }).then(function(data) {
                        //console.log(data.data);
                        if (data.data == "Data Inserted") {
                            swal("เสร็จสิ้น", "ข้อความของคุณถูกส่งให้ผู้รับแล้ว", "success");
                            //$scope.reciveuserid = $scope.users[0]['id'];
                        } else {
                            swal("บันทึกข้อมูลไม่สำเร็จ", "ข้อความของคุณยังไม่ถูกส่ง", "warning");
                        }
                    });
                }

            });

        </script>
    </body>
    <script src="dist/sweetalert.min.js"></script>

    </html>
