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
        if (!in_array("40", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div ng-app="reportenddayApp" ng-controller="reportenddaymainController" class="ng-scope">
        <div class="container">
            <div class="d-flex justify-content-center mb-4">
                <h3>ใบนำทางสินค้า </h3>
            </div>
            <table class="table table-bordered" ng-init="getreport()">
                <thead class="table-info">
                    <tr>
                        <th>เลขใบนำทาง</th>
                        <th>วันที่</th>
                        <th>พิมพ์ใบนำทาง</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in reports">
                        <td>{{item.rptno}}</td>
                        <td>{{item.rptdate}}</td>
                        <td><a href="reportProductToShelf.php?no={{item.rptno}}"><button class="btn btn-success">พิมพ์</button></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>
<script>
    var app = angular.module("reportenddayApp", []);
    app.controller("reportenddaymainController", function($scope, $http, $window) {

        $scope.getreport = function() {
            $http.post('php/getstocktoshelfcard.php', {

            }).then(function(res) {
                $scope.reports = res.data.records;
            });
        }








        //console.log(date) console.log(firstDay.getDate()) console.log(lastDay.getDate())
    })

</script>

</html>
