<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
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
        if (!in_array("23", $allowrule)){
            header("Location: auth.php");
        }
     ?>

    <div class="container">
        <h3 align="center">ยอดขายรายวัน</h3>
        <div ng-app="reportPosBillOutApp" ng-controller="reportPosBillOutcontroller" class="ng-scope">




            <div class="form-group row">

                <label class="col-sm-1 col-form-label font-weight-bold text-right " for="branch"> สาขา :</label>
                <select id="branch" name="branch" ng-model="branch" class="form-control col-sm-3 mr-2" ng-init="selectBranch()">
                <option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
                
            </select>

                <label class="col-sm-1 col-form-label font-weight-bold text-right " for="date1"> เลือกวัน :</label>
                <input type="date" name="date1" id="date1" ng-model="date1" class="form-control col-sm-2 mr-2">
                <label class="col-sm-1 col-form-label font-weight-bold text-right " for="date2"> ถึงวันที่ :</label>
                <input type="date" name="date2" id="date2" ng-model="date2" class="form-control col-sm-2 mr-2">

                <input type="submit" name="" ng-click="disPlayData()" class="btn btn-success col-sm-1" value="ตกลง" style="width: 117px;">
            </div>
            <table class="table table-info table-bordered" ng-init="disPlayData()">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>เลขที่บิล</th>
                        <th>รหัสสมาชิก</th>
                        <th>ยอดขายต่อบิล</th>
                        <th>เวลาขาย</th>
                        <th>กำไรต่อบิล</th>
                        <th>สาขา</th>


                    </tr>
                    <tr ng-repeat="bill in bills">
                        <td>{{$index + 1}}</td>
                        <td>{{billidCheck(bill.billno)}}</td>
                        <td>{{memidCheck(bill.memberid)}}</td>
                        <td>{{bill.sumprice}}</td>
                        <td>{{bill.masterdate | date:'dd/MM/yyyy h:mma'}}</td>
                        <td>{{bill.profit}} บาท</td>
                        <td>{{bill.branchname}}</td>
                    </tr>

                </tbody>
            </table>

            <p class="font-weight-bold">รวมยอดขาย&#160;{{ totalPrice }}&#160;บาท</p>
            <p class="font-weight-bold">รวมกำไร&#160;{{ totalprofit }}&#160;บาท</p>
        </div>
    </div>




    <script>
        var app = angular.module("reportPosBillOutApp", []);

        app.controller("reportPosBillOutcontroller", function($scope, $http) {

            $scope.branch = <?=$_SESSION["subbranchid"]?>;
            $scope.date1 = new Date();
            $scope.date2 = new Date();
            $scope.totalprofit = 0.00;

            $scope.totalPrice = 0.00;
            $scope.selectBranch = function() {

                $http.get('php/subbranchSelect.php').then(function(response) {
                    $scope.branchs = response.data.records;
                });

            };


            /*$scope.sumTotalPrice = function(p) {
                $scope.totalPrice = parseFloat(parseFloat($scope.totalPrice) + parseFloat(p)).toFixed(2);

            };*/
            $scope.formatDate = function(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            };
            $scope.disPlayData = function() {
                var date = new Date($scope.date1);
                var date2 = new Date($scope.date2);

                $http.get('php/getReportPosBillOut.php?branch=' + $scope.branch + '&date=' + $scope.formatDate(date) + '&date2=' + $scope.formatDate(date2)).then(function(res) {
                    $scope.bills = res.data.records;
                    $scope.totalprofit = 0.00;
                    $scope.totalPrice = 0.00;
                    for (var i = 0; i < $scope.bills.length; i++) {
                        $scope.totalprofit = $scope.totalprofit + parseFloat($scope.bills[i]['profit']);
                        $scope.totalPrice = $scope.totalPrice + parseFloat($scope.bills[i]['sumprice']);
                    }
                    //alert($scope.totalprofit);
                });

                $scope.memidCheck = function(id) {
                    if (id == "") {
                        return "ไม่ใช่สมาชิก";
                    }
                    return id;
                };

                $scope.billidCheck = function(id) {
                    if (id == null) {
                        return "ยังไม่มีเลขที่บิล";
                    }
                    return id;
                };
            }
        });

    </script>
    <script src="dist/sweetalert.min.js"></script>
</body>
