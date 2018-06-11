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
    <div ng-app="createpromotionApp" ng-controller="createpromotionmainController" class="ng-scope">
        <div>
            <div class="d-flex justify-content-center mb-2">
                <h3>สร้างโปรโมชัน</h3>
            </div>
            <div class="container" style="width:110%;">
                <div class="row mb-2">
                    <div class="col" ng-init="selectBranch()"><label>เลือกสาขา</label>
                        <select class="custom-select mb-1" ng-model="branch" ng-click="getstockinbranch()">
                        <option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
                       
                       </select>
                        <hr class="mb-1 mt-1">
                        <div class="row ">
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

                        <div style="height:232px; overflow-y: scroll;">
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
                        <div class="row">
                            <div class="col"><small class="form-text text-muted">Help text for a form field.</small></div>
                            <div class="col col-4">
                                <label>ราคาต่อชุด</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" />
                                    <div class="input-group-append"><button class="btn btn-success" ng-click="logtest()" type="button">✓<br /></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col">
                        <hr><label>รายการโปรโมชันของสาขา {{bottomsubbranch}}</label>
                        <div class="">
                            <table class="table table-bordered">
                                <thead class="table-info">
                                    <tr>
                                        <th>รหัสส่วนลด</th>
                                        <th>ชื่อส่วนลด</th>
                                        <th>ราคาต่อชุด</th>
                                        <th>มูลค่าส่วนลด</th>
                                        <th>ราคาเต็ม</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cell1</td>
                                        <td>Cell2</td>
                                        <td>Cell3</td>
                                        <td>Cell4</td>
                                        <td>Cell4</td>
                                        <td>Cell4</td>
                                    </tr>
                                    <tr>
                                        <td>Cell1</td>
                                        <td>Cell2</td>
                                        <td>Cell3</td>
                                        <td>Cell4</td>
                                        <td>Cell4</td>
                                        <td>Cell4</td>
                                    </tr>
                                    <tr>
                                        <td>Cell1</td>
                                        <td>Cell2</td>
                                        <td>Cell3</td>
                                        <td>Cell4</td>
                                        <td>Cell4</td>
                                        <td>Cell4</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</body>
<script>
    var app = angular.module("createpromotionApp", []);
    app.controller("createpromotionmainController", function($scope, $http, $window) {

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

        $scope.logtest = function() {
            alert($scope.branch);


        }
    });

</script>

</html>
