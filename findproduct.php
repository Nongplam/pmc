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
        if (!in_array("25", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div ng-app="findproductApp" ng-controller="findproductmainController" class="ng-scope">
        <div class="container">
            <div class="d-flex justify-content-center">
                <h3>ค้นหาที่อยู่สินค้า</h3>
            </div>
            <div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold text-center " for="branch"> สาขา :</label>
                    <select id="branch" name="branch" ng-model="branch" class="form-control col-sm-3" ng-init="selectBranch()">
                    <option ng-repeat="branch in branchs" value="{{branch.id}}" selected>{{branch.name}}</option>
                    <option value="undefined">สาขาทั้งหมด</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold text-center " for="branch"> Barcode :</label>
                    <input class="input-group-text col-sm-3" ng-keyup="findbyEnter($event)" ng-model="barcode" />
                </div>
                <!--<div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold text-center " for="branch"> Stockid :</label>
                    <input class="input-group-text col-sm-3" ng-model="stockid" />

                </div>-->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold text-center " for="branch"></label>
                    <button class="btn btn-success col-sm-3" ng-click="getfindProduct()">ค้นหา</button>
                </div>
            </div>
            <div>
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>สาขา</th>
                            <th>ชั้นวางหมายเลข</th>
                            <th>ตำแหน่ง</th>
                            <th>เลขที่สต๊อก</th>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวน</th>
                            <th>หน่วย</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in products">
                            <td>{{item.branchname}}</td>
                            <td>{{item.shelfno}}</td>
                            <td>{{item.shelfinfo}}</td>
                            <td>{{item.sid}}</td>
                            <td>{{item.pname}}</td>
                            <td>{{item.shelfremain}}</td>
                            <td>{{item.stocktype}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>

            </div>
        </div>
    </div>
    <script>
        var app = angular.module("findproductApp", []);
        app.controller("findproductmainController", function($scope, $http, $window) {
            $scope.selectBranch = function() {
                $http.get('php/subbranchSelect.php').then(function(response) {
                    $scope.branchs = response.data.records;
                });
            };

            $scope.getfindProduct = function() {
                var barcode = $scope.barcode;
                var branch = $scope.branch;
                $scope.showhistorytable = true;
                $http.get('php/getfindProduct.php?branch=' + branch + '&barcode=' + barcode).then(function(response) {
                    $scope.products = response.data.records;
                });
            }

            $scope.findbyEnter = function(e) {
                if (e.keyCode == 13) {
                    $scope.getfindProduct();
                }
            }

        });

    </script>
</body>
<script src="dist/sweetalert.min.js"></script>

</html>
