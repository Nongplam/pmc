<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bill</title>

    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
</head>

<body>
    <div class="col" ng-app="billApp" ng-controller="billsCtrl" ng-init="billItem()" style="height:auto;width:309px;">
        <div class="container border border-dark">
            <div class="row d-flex justify-content-center"><span><?php echo $_SESSION["subbranchname"]; ?></span><span>({{billbranchid}})</span></div>
            <div class="row d-flex justify-content-center"><span>TAX detailed</span></div>
            <div class="row d-flex justify-content-center"><span>ใบเสร็จรับเงิน</span></div>
            <div class="row" style="margin-bottom: -20px;">
                <div class="table-responsive">
                    <table class="table">
                        <!--<thead>
                            <tr>
                                <th>qty</th>
                                <th>name</th>
                                <th>p/qty</th>
                                <th>total</th>
                            </tr>
                        </thead>-->
                        <tbody>
                            <tr ng-repeat="x in bills" style="margin-bottom: -10px;margin-top: -10px;font-size: 80%;">
                                <td>{{x.qty}}</td>
                                <td>{{getPnames(x.stockid)}}</td>
                                <td class="money">{{x.price}}</td>
                                <td class="money">{{x.price*x.qty}}</td>
                                <td ng-show="false" class="masterid">{{getbillDatetime(x.masterid)}} {{getmoneyReceive(x.masterid)}} {{getbillmoneyChange(x.masterid)}}</td>
                                <td ng-show="false" class="subid">{{getsubbranchTel(x.subbranchid)}} {{getbillsubbranchId(x.subbranchid)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col"><span style="font-size: 80%;">ยอดสุทธิ</span></div>
                <div class="col"><span>{{getqtyTotal()}} ชิ้น</span></div>
                <div class="col money"><span>{{getpriceTotal()}}</span></div>
            </div>
            <div class="row">
                <div class="col col-5"><span style="font-size: 80%;">เงินสด/เงินทอน</span></div>
                <div class="col col-3"><span class="money">{{billmoneyreceive}}</span></div>
                <div class="col col-3"><span class="money">{{billmoneychange}}</span></div>
            </div>
            <div class="row">
                <div class="col col-5" style="font-size: 80%;"><span>R#0001 B:01</span></div>
                <!--<div class="col"><span>22/2/18  06:21</span></div>-->
                <div class="col col-7"><span>{{billdate}} {{billtime}}</span></div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center"><span>*ติดต่อสอบถาม {{billtel}}*</span></div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center"><span>..............................................................................</span></div>
            </div>
            <div class="row d-flex justify-content-center"><span class="border border-dark rounded" style="font-size:40px;height: 130px;">พื้นที่โปรโมชัน</span></div>
            <div class="row">
                <div class="col d-flex justify-content-center"><span>..............................................................................</span></div>
            </div>
            <div class="row"><img src="img/bill/endbill.png" style="width:279px;height:auto;" /></div>
        </div>
    </div>

</body>
<script>
    var billapp = angular.module('billApp', []);
    billapp.controller('billsCtrl', function($scope, $http) {
        $scope.billdate = '';
        $scope.billtime = '';
        $scope.billtel = '';
        $scope.billmoneyreceive = '';
        $scope.billmoneychange = '';
        $scope.billbranchid = '';
        $scope.billItem = function() {
            $http.get("php/billItem.php").then(function(response) {
                $scope.bills = response.data.records;
            });
        }
        $scope.getqtyTotal = function() {
            var totalqty = 0;
            if ($scope.bills !== undefined) {
                for (var i = 0; i < $scope.bills.length; i++) {
                    var bill = $scope.bills[i];
                    totalqty += (parseInt(bill.qty));
                }
            }
            //console.log(totalqty);
            return (totalqty);
        }
        $scope.getbillsubbranchId = function(sid) {
            $scope.billbranchid = sid;
        }
        $scope.getpriceTotal = function() {
            var totalgetpriceTotal = 0;
            if ($scope.bills !== undefined) {
                for (var i = 0; i < $scope.bills.length; i++) {
                    var bill = $scope.bills[i];
                    totalgetpriceTotal += (parseInt(bill.qty * bill.price));
                }
            }
            //console.log(totalgetpriceTotal);
            return (totalgetpriceTotal);
        }
        $scope.getPnames = function(sid) {
            var a = "gg";
            $.ajax({
                async: false,
                url: "php/getPname.php?stockid=" + sid,
                success: function(data) {
                    a = data;
                }
            });
            return a;
        }
        $scope.getmoneyReceive = function(mid) {
            var a = "gg";
            $.ajax({
                async: false,
                url: "php/getbillmoneyReceive.php?masterid=" + mid,
                success: function(data) {
                    a = data;
                }
            });
            $scope.billmoneyreceive = a;
        }
        $scope.getbillmoneyChange = function(mid) {
            var a = "gg";
            $.ajax({
                async: false,
                url: "php/getbillmoneyChange.php?masterid=" + mid,
                success: function(data) {
                    a = data;
                }
            });
            $scope.billmoneychange = a;
        }
        $scope.getbillDatetime = function(mid) {
            var a = "gg";
            var year = '';
            var month = '';
            var day = '';
            var thaidate = '';
            var hour = '';
            var minute = '';
            var thaitime = '';
            $.ajax({
                async: false,
                url: "php/getbillDatetime.php?masterid=" + mid,
                success: function(data) {
                    a = data;
                }
            });
            for (var i = 0; i < 4; i++) {
                year = year + a[i];
            }
            year = parseInt(year) + 543;
            for (var i = 5; i < 7; i++) {
                month = month + a[i];
            }
            for (var i = 8; i < 10; i++) {
                day = day + a[i];
            }
            thaidate = day + '/' + month + '/' + year;
            for (var i = 11; i < 13; i++) {
                hour = hour + a[i];
            }
            for (var i = 14; i < 16; i++) {
                minute = minute + a[i];
            }
            thaitime = hour + ':' + minute;
            //console.log(thaitime)
            $scope.billdate = thaidate;
            $scope.billtime = thaitime;
        }
        $scope.getsubbranchTel = function(subid) {
            var a = "gg";
            var tel = '';
            $.ajax({
                async: false,
                url: "php/getsubbranchTel.php?branchid=" + subid,
                success: function(data) {
                    a = data;
                }
            });
            tel = a[0] + a[1] + a[2] + '-' + a[3] + a[4] + a[5] + '-' + a[6] + a[7] + a[8] + a[9]
            $scope.billtel = tel;
            //console.log(tel);
            //return a;
        }
    });

</script>
<script>
    $(document).ready(setTimeout(function() {
        //window.print();
    }, 1000));

</script>
<script>
    $(document).ready(setTimeout(function() {
        $(".money").each(function() {
            var cash = parseInt($(this).text());
            $(this).text(cash.toFixed(2));
            //console.log(cash);

        });
    }, 500));

</script>

</html>
