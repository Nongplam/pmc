<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/3/2018
 * Time: 6:35 PM
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

<body>
<?php
    include 'mainbartest.php';
$subid= $_SESSION['subbranchid'];
include "php/connectDB.php";
$sql = "SELECT subbranch.name FROM subbranch WHERE subbranch.id = $subid";


$result = mysqli_query($con,$sql);

$row = $result ->fetch_array(1);

/*$role=$_SESSION["role"];
$allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
$allowqueryresult=mysqli_query($con,$allowquery);
$allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);
$allowrule = explode(",",$allowruleraw["rule"]);
if (!in_array("26", $allowrule)){
    header("Location: auth.php");
}*/
?>




<div class="container">
    <h3 align="center">รายงานสินค้าในคลัง สาขา<?=$row['name']?> </h3>
    <div ng-app="reportStockBranchApp" ng-controller="reportStockBranchcontroller" class="ng-scope">

        <input type="text" ng-model="search" class="form-control">


        <table class="table table-info table-bordered" >
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>เลขสต็อค</th>
                    <th>เลขที่ใบสั่งซื้อ</th>
                    <th>เลขลอต</th>
                    <th>แบรนด์</th>
                    <th>คู่ค้า</th>
                    <th>จำนวนรับเข้า</th>
                    <th>จำนวนคงเหลือ</th>
                    <th>หน่วย</th>
                    <th>ราคาทุน</th>
                    <th>ราคาขาย</th>
                    <th>วันที่รับ</th>
                    <th>วันหมดอายุ</th>
                </tr>
            </thead>
            <tbody ng-init="getAllStock()">
                <tr  ng-repeat= "stock in stocks | filter:search" >
                    <td>{{stock.pname}}</td>
                    <td>{{stock.sid}}</td>
                    <td>{{stock.PO_No}}</td>
                    <td>{{stock.lotno}}</td>
                    <td>{{stock.bname}}</td>
                    <td>{{stock.cname}}</td>
                    <td>{{stock.remainfull}}</td>
                    <td>{{stock.remain}}</td>
                    <td>{{stock.stocktype}}</td>
                    <td>{{stock.costprice}}</td>
                    <td>{{stock.baseprice}}</td>
                    <td>{{stock.receiveday}}</td>
                    <td>{{stock.expireday}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>





<script>



    var app = angular.module("reportStockBranchApp", []);

    app.controller("reportStockBranchcontroller", function ($scope, $http) {



        $scope.getAllStock = function(){
            $http.post("php/getStockBranch.php").then( function(response){
                $scope.stocks = response.data.records;

            });

        }



    });

</script>
</body>


</html>
