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
                        <thead class="bg-info">
                            <tr>
                                <th>สาขา</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>หน่วย</th>
                                <th>คลังใหญ่ (ชิ้น)</th>
                                <th>คงเหลือสาขา (ชิ้น)</th>
                                <th>เฉลี่ยขายต่อวัน</th>
                                <th ng-click="orderbyemptyindayToggle()">สินค้าจะหมดใน (วัน)<span><img src="svg/si-glyph-disc-play-2.svg" height="15" width="15"/></span>
                                    <!--<button type="button" class="btn btn-default btn-sm">
           Sort
        </button>--></th>
                                <th>Action</th>
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
                                <!--<th>{{formattofix2(item.branchremain/item.aveusedperday)}}</th>-->
                                <td>
                                    <button class="btn btn-primary"><input type="text" class="input-group input-group-text" /><span>&nbsp;จัดส่ง</span></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            var app = angular.module("drugusedApp", []);
            app.controller("drugusedmainController", function($scope, $http, $window) {

                $scope.orderbyemptyinday = 'emptyinday';

                $scope.getusedperday = function() {
                    $http.get('php/getReportDrugUsed.php').then(function(response) {
                        $scope.usedperdays = response.data.records;
                        for (var i = 0; i < $scope.usedperdays.length; i++) {
                            $scope.usedperdays[i]['emptyinday'] = $scope.usedperdays[i]['branchremain'] / $scope.usedperdays[i]['aveusedperday'];
                            $scope.usedperdays[i]['emptyinday'] = parseFloat($scope.usedperdays[i]['emptyinday'].toFixed(2)); //.toFixed(2);
                        }
                    });
                }
                $scope.logtest = function() {
                    alert("Workd");
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


            });

        </script>
    </body>

    </html>
