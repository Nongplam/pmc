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
    <style>
        @font-face {
            font-family: myFirstFont;
            src: url(dist/Waree-Bold.woff);            
        }

        .fonthere {
            font-family: myFirstFont;
            font-size: 17px;
        }

    </style>
</head>

<body>
    <div class="col" ng-app="billApp" ng-controller="billsCtrl" ng-init="billItem()">

        <div style="width:300px;">
           <div class="fonthere">
            <div class="row d-flex justify-content-center"><span><?php echo $_SESSION["subbranchname"]; ?></span><span>(<?php echo $_SESSION["subbranchid"]; ?>)</span></div>
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
                            <tr ng-repeat="x in bills" ng-init="setdetail()" style="margin-bottom: -10px;margin-top: -10px;font-size: 80%;">
                                <td>{{x.qty}}</td>
                                <td>{{x.pname}}</td>
                                <td class="money">{{getdecimalFormat(x.price)}}</td>
                                <td class="money">{{getdecimalFormat(x.price*x.qty)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col"><span style="font-size: 80%;">ยอดสุทธิ</span></div>
                <div class="col"><span>{{qtytotal}} ชิ้น</span></div>
                <div class="col money"><span>{{getdecimalFormat(sumpricetotal)}}</span></div>
            </div>
            <div class="row">
                <div class="col col-5"><span style="font-size: 80%;">เงินสด/เงินทอน</span></div>
                <div class="col col-3"><span class="money">{{getdecimalFormat(billmoneyreceive)}}</span></div>
                <div class="col col-3"><span class="money">{{getdecimalFormat(billmoneychange)}}</span></div>
            </div>
            <div class="row">
                <div class="col col-5" style="font-size: 80%;"><span>R#0001 B:01</span></div>
                <!--<div class="col"><span>22/2/18  06:21</span></div>-->
                <div class="col col-7"><span>{{saledate}} {{saletime}}</span></div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center"><span>*ติดต่อสอบถาม {{tel}}*</span></div>
            </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center"><span>..............................................................................</span></div>
            </div>
            <div class="row d-flex justify-content-center"><span class="border border-dark rounded" style="font-size:40px;height: 130px;">พื้นที่โปรโมชัน</span></div>
            <div class="row">
                <div class="col d-flex justify-content-center"><span>..............................................................................</span></div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center"><img src="img/bill/endbill.png" style="width:279px;height:auto;" /></div>
            </div>
        </div>
    </div>

</body>
<script>
    var billapp = angular.module('billApp', []);
    billapp.controller('billsCtrl', function($scope, $http) {

        $scope.billmoneyreceive = 0;
        $scope.billmoneychange = 0;

        $scope.qtytotal = 0;
        $scope.sumpricetotal = 0;
        $scope.saledate = '';
        $scope.saletime = '';
        $scope.tel = '';
        $scope.billItem = function() {
            $http.get("php/billItem.php").then(function(response) {
                $scope.bills = response.data.records;
            });
        }
        $scope.getdecimalFormat = function(money) {
            return parseFloat(money).toFixed(2);
        }

        $scope.setdetail = function() {
            $scope.qtytotal = 0;
            $scope.sumpricetotal = 0;
            //console.log($scope.bills["0"].qty);
            //console.log($scope.bills);
            for (var i = 0; i < $scope.bills.length; i++) {
                $scope.qtytotal = $scope.qtytotal + parseInt($scope.bills[i].qty);
            }
            for (var i = 0; i < $scope.bills.length; i++) {
                $scope.sumpricetotal = $scope.sumpricetotal + (parseInt($scope.bills[i].qty) * parseInt($scope.bills[i].price));
            }
            $scope.billmoneyreceive = $scope.bills["0"].moneyreceive;
            $scope.billmoneychange = $scope.bills["0"].moneychange;
            var datetemp = new Date($scope.bills["0"].date);
            //console.log($scope.bills["0"].date);
            var monthtemp = datetemp.getMonth() + 1;
            var yeartemp = datetemp.getFullYear() + 543;
            $scope.saledate = datetemp.getDate() + "/" + monthtemp + "/" + yeartemp;
            $scope.saletime = datetemp.getHours() + ":" + datetemp.getMinutes();
            var strtemp = datetemp.getHours() + ":" + datetemp.getMinutes();
            $scope.tel = $scope.bills["0"].tel;
        }
    });

</script>
<!--<script>
    $(document).ready(setTimeout(function() {
        window.print();
        
    }, 1000));

</script>-->


</html>
