<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/popper.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>



</head>

<body>
    <?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("12", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div class="container" style="width:70%">
        <h3 align="center">รายงานสินค้าในสต๊อคใกล้หมดอายุ</h3>
        <div ng-app="reportStockExpireApp" ng-controller="reportStockExpirecontroller" class="ng-scope">
            <form class="row container">

                <label class="align-self-center mr-2">สาขา :</label>
                <select id="branch" name="branch" ng-model="branch" class="form-control custom-select col-sm-4" ng-init="selectBranch()">
<option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
    
</select>
                <!--<input type="radio" name="rChk" ng-model = "rChk" value = "1"> ทั้งหมด -->
                <!--<input type="radio" name="rChk" ng-model="rChk" value="2"> ใกล้หมดอายุ
                <input type="radio" name="rChk" ng-model="rChk" value="3"> หมดอายุ-->

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle mr-2 ml-2" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                    สินค้าที่ใกล้หมดอายุ<!--{{filtermode}}-->
                            </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item" ng-click="numdayfilter = 9999; filtermode = 'แสดงทั้งหมด'">สินค้าที่ใกล้หมดอายุ</button>
                        <button class="dropdown-item" ng-click="numdayfilter = 14; filtermode = 'สิ้นค้าที่จะหมดภายใน 14 วัน'">สิ้นค้าหมดอายุแล้ว</button>
                        <button class="dropdown-item" ng-click="numdayfilter = 7; filtermode = 'สิ้นค้าที่จะหมดภายใน 7 วัน'">แสดงทั้งหมด</button>
                    </div>
                </div>
                <input type="submit" name="" ng-click="getAllStock()" class="btn btn-success" value="ตกลง" style="width: 117px;">
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr class="table-info">
                        <th>เลขสต็อค</th>
                        <th>ผลิตภัณฑ์</th>
                        <th>จำนวน</th>
                        <th>หน่วย</th>
                        <th>ราคาทุน</th>
                        <th>เลขลอต</th>
                        <th>วันหมดอายุ</th>
                        <th>จะหมดอายุใน (วัน)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="stock in stocks  | orderBy:'DateDiff'">
                        <td>{{stock.sid}}</td>
                        <td>{{stock.pname}}</td>
                        <td>{{stock.sumremain}}</td>
                        <td>{{stock.stocktype}}</td>
                        <td>{{stock.costprice}}</td>
                        <td>{{stock.lotno}}</td>
                        <td>{{stock.expireday}}</td>
                        <td>{{stock.DateDiff}}</td>

                    </tr>

                </tbody>
            </table>


        </div>
    </div>




    <script>
        var app = angular.module("reportStockExpireApp", []);

        app.controller("reportStockExpirecontroller", function($scope, $http) {

            $scope.selectBranch = function() {

                $http.get('php/subbranchSelect.php').then(function(response) {


                    $scope.branchs = response.data.records;
                    $scope.branch = $scope.branchs[0]['id'];

                });
            }

            $scope.getAllStock = function() {



                $http.get('php/getReportStockExpire.php?branch=' + $scope.branch + '&type=' + $scope.rChk).then(function(response) {


                    $scope.stocks = response.data.records;
                    for (var i = 0; i < $scope.stocks.length; i++) {
                        $scope.stocks[i]['DateDiff'] = parseInt($scope.stocks[i]['DateDiff']);
                    }

                });
                /*console.log($scope.branch);
                console.log($scope.rChk);*/
            }



        });

    </script>
    <script src="dist/sweetalert.min.js"></script>
</body>
