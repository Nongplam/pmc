<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 5/30/2018
 * Time: 4:15 PM
 */

$pname = $_GET['pname'];
$type = $_GET['type'];
?>
<html>

<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>

</head>

<body ng-app="reportStockCardApp" ng-controller="reportStockCardcontroller">
        <?php
          /*  include 'mainbartest.php';
            $role=$_SESSION["role"];
            $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
            $allowqueryresult=mysqli_query($con,$allowquery);
            $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);
            $allowrule = explode(",",$allowruleraw["rule"]);
            if (!in_array("10", $allowrule)){
                header("Location: auth.php");
            }*/
        ?>


<div class="container">


    <table class="table table-bordered">
        <tr>
            <th><?=$pname?></th>
            <th><?=$type?></th>
        </tr>
    </table>

    <div class="form-group form-check-inline">
        <input type="date" class="form-control col-6" ng-model="from_date">
        <input type="date"  class="form-control col-6" ng-model="to_date">



    </div>
    <table class="table table-info">
        <thead ng-init="getStatement()">
            <tr>
                <th>วัน/เวลา</th>
                <th>ใบสั่งซื้อ</th>
                <th>เลขลอต</th>
                <th>เลขที่ใบเสร็จ</th>
                <th>วันหมดอายุ</th>
                <th>ราคาขาย</th>
                <th>ต้นทุน</th>
                <th>จำนวน</th>
                <th>ยอดคงเหลือ</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="state in states | myfilter:from_date:to_date ">
                <td>{{state.date}}</td>
                <td>{{state.PO_No}}</td>
                <td>{{state.lotno}}</td>
                <td>{{state.billno}}</td>
                <td>{{state.expireday}}</td>
                <td>{{state.price}}</td>
                <td>{{state.costprice}}</td>
                <td>{{state.qty}}</td>
                <td>{{state.balanch}}</td>
            </tr>
        </tbody>
    </table>

</div>



<script>


    var app = angular.module("reportStockCardApp", []);


    app.filter("myfilter", function() {
        return function(items, fromDate, toDate) {

            var from_date = new Date(fromDate);
            var to_date = new Date(toDate);
            var from_date2 = new Date(from_date.getFullYear(),from_date.getMonth(),from_date.getDate());
            var to_date2 = new Date(to_date.getFullYear(),to_date.getMonth(),to_date.getDate());
            console.log(from_date2,to_date2);

            var result = [];



            angular.forEach(items, function(item) {


                if( new Date( item.date) >=  from_date2 && new Date(item.date) <= to_date2) {

                    result.push(item);
                }
            });
            return result;
        };
    });


    app.controller("reportStockCardcontroller", function ($scope, $http) {

        $scope.from_date = new Date();
        $scope.to_date = new Date();

        $scope.getStatement = function(){
            $scope.pname = "<?=$pname?>";
            $scope.type = "<?=$type?>";
            $http.post('php/calBa.php',{
                'pname': $scope.pname  ,
                'type':  $scope.type
            }).then( function(response){

                $scope.states = response.data.records;

            });

        };



    });
</script>




</body>








</html>

