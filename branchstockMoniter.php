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
    <div ng-app="branchstocksumApp" ng-controller="branchstocksummainController" class="ng-scope">
        <div class="container">
            <div class="d-flex justify-content-center">
                <h3>สำรวจสต๊อกสาขาย่อย</h3>
            </div>
            <div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold text-center " for="branch"> เลือกสาขา :</label>
                    <select id="branch" name="branch" ng-model="branch" class="form-control col-sm-8" ng-init="selectBranch()">
                    <option ng-repeat="branch in branchs" value="{{branch.id}}" selected>{{branch.name}}</option>
                    <option value="undefined">สาขาทั้งหมด</option>
                    </select>
                    <button class="btn btn-primary col-sm">ค้นหา</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var app = angular.module("branchstocksumApp", []);
        app.controller("branchstocksummainController", function($scope, $http, $window) {
            $scope.selectBranch = function() {
                $http.get('php/subbranchSelect.php').then(function(response) {
                    $scope.branchs = response.data.records;
                });
            };
        });

    </script>
</body>

</html>
