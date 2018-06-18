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
        if (!in_array("28", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div ng-app="reportenddayApp" ng-controller="reportenddaymainController" class="ng-scope">
        <div class="container">
            <div class="d-flex justify-content-center mb-4">
                <h3>รายงานยอดขายรายสาขา</h3>
            </div>
            <!--<div class="d-flex justify-content-center">
                <h3>ประจำสาขา ห้วยผึ้ง</h3>
            </div>-->
            <div class="row mb-3 d-flex justify-content-center">
                <label class="col-2 col-form-label font-weight-bold text-right " for="date1"> ข้อมูล ณ วันที่ :</label>
                <input type="date" name="date1" id="date1" ng-model="date1" ng-change="getreport()" class="form-control col-2 mr-2">
                <label class="col-1 col-form-label font-weight-bold text-right" for="date2">ถึง</label>
                <input type="date" name="date2" id="date2" ng-model="date2" ng-change="getreport()" class="form-control col-2 mr-2">
                <input type="submit" name="" ng-click="getreport()" class="btn btn-success col-sm-1" value="ตกลง" style="width: 117px;">
            </div>
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>สาขา</th>
                        <th class="text-right">จำนวนรายการ</th>
                        <th class="text-right">ยอดขาย</th>
                        <th class="text-right">ต้นทุน</th>
                        <th class="text-right">กำไร</th>
                        <!--<th>วันที่</th>-->
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="list in reports">
                        <td>{{list.name}}</td>
                        <td class="text-right">{{list.totalbill}}</td>
                        <td class="text-right">{{list.totalsale}} .-</td>
                        <td class="text-right">{{list.totalcost}} .-</td>
                        <td class="text-right">{{list.totalprofit}} .-</td>
                        <!--<td>{{list.date}}</td>-->
                    </tr>
                    <tr ng-show="isgetreport" class="table-success">
                        <td><b>รวม</b></td>
                        <td class="text-right"><b><u>{{sumtotalbill}}</u></b></td>
                        <td class="text-right"><b><u>{{sumtotalsale}}</u> .-</b></td>
                        <td class="text-right"><b><u>{{sumtotalcost}}</u> .-</b></td>
                        <td class="text-right"><b><u>{{sumtotalprofit}}</u> .-</b></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>
<script>
    var app = angular.module("reportenddayApp", []);
    app.controller("reportenddaymainController", function($scope, $http, $window) {
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $scope.date1 = new Date();
        $scope.date1.setHours(0);
        $scope.date1.setMinutes(0);
        $scope.date2 = new Date();
        $scope.date2.setHours(23);
        $scope.date2.setMinutes(59);
        $scope.date1.setDate(firstDay.getDate());
        $scope.date2.setDate(lastDay.getDate());
        $scope.isgetreport = false;


        $scope.getreport = function() {
            var d1month = parseInt($scope.date1.getMonth());
            d1month++;
            var d2month = parseInt($scope.date2.getMonth());
            d2month++;
            var datestartstr = $scope.date1.getFullYear() + '-' + d1month + '-' + $scope.date1.getDate();
            var dateendstr = $scope.date2.getFullYear() + '-' + d2month + '-' + $scope.date2.getDate();
            $http.post('php/getenddayReport.php', {
                'datestart': datestartstr,
                'dateend': dateendstr
            }).then(function(res) {
                $scope.isgetreport = true;
                $scope.reports = res.data.records;
                $scope.sumtotalbill = 0;
                $scope.sumtotalsale = 0;
                $scope.sumtotalprofit = 0;
                $scope.sumtotalcost = 0;
                for (var i = 0; i < $scope.reports.length; i++) {
                    $scope.sumtotalbill = $scope.sumtotalbill + parseFloat($scope.reports[i]['totalbill']);
                    $scope.sumtotalsale = parseFloat($scope.sumtotalsale + parseFloat($scope.reports[i]['totalsale']));
                    $scope.sumtotalprofit = parseFloat($scope.sumtotalprofit + parseFloat($scope.reports[i]['totalprofit']));
                    $scope.sumtotalcost = parseFloat($scope.sumtotalcost + parseFloat($scope.reports[i]['totalcost']));

                    $scope.reports[i]['totalsale'] = parseFloat($scope.reports[i]['totalsale']).toFixed(2)
                    $scope.reports[i]['totalsale'] = $scope.reports[i]['totalsale'].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $scope.reports[i]['totalprofit'] = parseFloat($scope.reports[i]['totalprofit']).toFixed(2)
                    $scope.reports[i]['totalprofit'] = $scope.reports[i]['totalprofit'].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $scope.reports[i]['totalcost'] = parseFloat($scope.reports[i]['totalcost']).toFixed(2)
                    $scope.reports[i]['totalcost'] = $scope.reports[i]['totalcost'].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                $scope.sumtotalsale = parseFloat($scope.sumtotalsale).toFixed(2);
                $scope.sumtotalprofit = parseFloat($scope.sumtotalprofit).toFixed(2);
                $scope.sumtotalcost = parseFloat($scope.sumtotalcost).toFixed(2);
                $scope.sumtotalsale = $scope.sumtotalsale.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $scope.sumtotalprofit = $scope.sumtotalprofit.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $scope.sumtotalcost = $scope.sumtotalcost.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                //console.log(res.data);
            });
        }
        $scope.getreport();






        //console.log(date) console.log(firstDay.getDate()) console.log(lastDay.getDate())
    })

</script>

</html>
