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
        if (!in_array("29", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div ng-app="reportenddayApp" ng-controller="reportenddaymainController" class="ng-scope">
        <div class="container">
            <div class="d-flex justify-content-center mb-4">
                <h3>รายงานยอดขายรายสาขา </h3>
            </div>
            <!--<div class="d-flex justify-content-center">
                <h3>ประจำสาขา ห้วยผึ้ง</h3>
            </div>-->
            <div class="row mb-3">
                <label class="col-2 col-form-label font-weight-bold text-right " for="date1"> ข้อมูลระหว่างวันที่ :</label>
                <input type="date" name="date1" id="date1" ng-model="date1" class="form-control col-3 mr-2">
                <label class="col-1 col-form-label font-weight-bold text-right" for="date2">ถึง</label>
                <input type="date" name="date2" id="date2" ng-model="date2" class="form-control col-3 mr-2">
                <input type="submit" name="" ng-click="getreport()" class="btn btn-success col-sm-1" value="ตกลง" style="width: 117px;">
            </div>
            <div class="row mb-3 ml-0">
                <label class="col-sm-1 col-form-label font-weight-bold text-right " for="branch"> สาขา :</label>
                <select id="branch" name="branch" ng-model="branch" class="form-control col-sm-3 mr-2" ng-init="selectBranch()">
                <option ng-repeat="branch in branchs" value="{{branch.id}}" selected>{{branch.name}}</option>
                </select>
            </div>
            <div>

            </div>
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>#</th>
                        <th>รายการขาย</th>
                        <th>หน่วย</th>
                        <th class="text-right">จำนวน</th>
                        <th class="text-right">ยอดขาย</th>
                        <th class="text-right">ต้นทุน</th>
                        <th class="text-right">กำไร</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in reports">
                        <td>{{$index+1}}</td>
                        <td>{{item.pname}}</td>
                        <td>{{item.stocktype}}</td>
                        <td class="text-right">{{item.qty}}</td>
                        <td class="text-right">{{item.priceperlist}} .-</td>
                        <td class="text-right">{{item.costperlist}} .-</td>
                        <td class="text-right">{{item.profitperlist}} .-</td>
                    </tr>
                    <tr class="table-success" ng-show="isgetreport">
                        <td><b><u>{{reports.length}}</u></b></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b><u>{{sumtotalqty}}</u></b></td>
                        <td class="text-right"><b><u>{{sumtotalprice}}</u> .-</b></td>
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

        $scope.selectBranch = function() {
            $http.get('php/subbranchSelect.php').then(function(response) {
                $scope.branchs = response.data.records;
                $scope.branch = $scope.branchs[0]['id'];
            });
        };

        $scope.getreport = function() {
            var d1month = parseInt($scope.date1.getMonth());
            d1month++;
            var d2month = parseInt($scope.date2.getMonth());
            d2month++;
            var datestartstr = $scope.date1.getFullYear() + '-' + d1month + '-' + $scope.date1.getDate();
            var dateendstr = $scope.date2.getFullYear() + '-' + d2month + '-' + $scope.date2.getDate();
            $http.post('php/getreportdrugsalebyBranch.php', {
                'datestart': datestartstr,
                'dateend': dateendstr,
                'branch': $scope.branch
            }).then(function(res) {
                $scope.reports = res.data.records;
                $scope.isgetreport = true;
                $scope.sumtotalqty = 0;
                $scope.sumtotalprice = 0;
                $scope.sumtotalprofit = 0;
                $scope.sumtotalcost = 0;
                for (var i = 0; i < $scope.reports.length; i++) {
                    $scope.sumtotalqty = $scope.sumtotalqty + parseFloat($scope.reports[i]['qty']);
                    $scope.sumtotalprice = parseFloat($scope.sumtotalprice + parseFloat($scope.reports[i]['priceperlist']));
                    $scope.sumtotalprofit = parseFloat($scope.sumtotalprofit + parseFloat($scope.reports[i]['profitperlist']));
                    $scope.sumtotalcost = parseFloat($scope.sumtotalcost + parseFloat($scope.reports[i]['costperlist']));

                    $scope.reports[i]['priceperlist'] = parseFloat($scope.reports[i]['priceperlist']).toFixed(2)
                    $scope.reports[i]['priceperlist'] = $scope.reports[i]['priceperlist'].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $scope.reports[i]['profitperlist'] = parseFloat($scope.reports[i]['profitperlist']).toFixed(2)
                    $scope.reports[i]['profitperlist'] = $scope.reports[i]['profitperlist'].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $scope.reports[i]['costperlist'] = parseFloat($scope.reports[i]['costperlist']).toFixed(2)
                    $scope.reports[i]['costperlist'] = $scope.reports[i]['costperlist'].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                $scope.sumtotalprice = parseFloat($scope.sumtotalprice).toFixed(2);
                $scope.sumtotalprofit = parseFloat($scope.sumtotalprofit).toFixed(2);
                $scope.sumtotalcost = parseFloat($scope.sumtotalcost).toFixed(2);
                $scope.sumtotalprice = $scope.sumtotalprice.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $scope.sumtotalprofit = $scope.sumtotalprofit.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $scope.sumtotalcost = $scope.sumtotalcost.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                /*console.log($scope.sumtotalqty);
                console.log($scope.sumtotalprice);
                console.log($scope.sumtotalprofit);
                console.log($scope.sumtotalcost);*/
                //console.log(res.data);
            });
        }


        //console.log(date) console.log(firstDay.getDate()) console.log(lastDay.getDate())
    })

</script>

</html>
