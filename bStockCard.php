<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/2/2018
 * Time: 6:21 PM
 */

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
<body ng-app="selectBstockCardApp" ng-controller="selectBstockCardcontroller">

    <div class="container">
        <input type="text" id="pname" name="pname" ng-model="pname" class="form-control" >



        <table class="table table-active">
            <thead>
            <tr>
                <th>ชื่อ</th>
                <th>หน่วย</th>
            </tr>

            </thead>
            <tbody ng-init="selectProduct()">
            <tr ng-repeat="product in products | filter:pname">
                <td>{{product.pname}}</td>
                <td>{{product.type}}</td>
                <td> <a href="reportStockCard.php?pname={{product.pname}}&type={{product.type}}" target="_blank"> <button class="btn btn-primary" ng-click = "">View</button></a></td>
            </tr>
            </tbody>
        </table>

    </div>


<script>
    var app = angular.module("selectBstockCardApp", []);

    app.controller("selectBstockCardcontroller", function ($scope, $http) {


        $scope.selectProduct = function(){

            $http.get('php/getPnameBstockCard.php').then( function(response){


                $scope.products = response.data.records;

            });
        };





    });
</script>
</body>

</html>
