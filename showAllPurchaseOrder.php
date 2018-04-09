

<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 */


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>รายการใบสั่งซื้อสินค้า</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

</head>
<body>
<?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("22", $allowrule)){
            header("Location: auth.php");
        }
     ?>

<div ng-app="showAllPurchaseOrderApp" ng-controller="showAllPurchaseOrderController"  class="ng-scope">
    <div class=" container">
        <br>
        <h3 align="center">รายการใบสั่งซื้อสินค้า</h3>
        <hr>
        <table class="table">
            <thead>
            <tr class="table-info">
                <th>เลขที่ใบสั่งซื้อ</th>
                <th>วันที่สั่ง</th>
            </tr>
            </thead >

            <tbody ng-init="getAllPurchaseOrder()" >
            <tr ng-repeat="PO in POs | orderBy : '-rptPO_no'">
                <td>{{PO.rptPO_no}}</td>
                <td>{{PO.rptPO_date}}</td>
                <td><a href="reportPurchaseOrder.php?NO={{PO.rptPO_no}}" target="_blank"><button class="btn btn-info"><span class="icon ion-document-text font-weight-bold"></span>&#160;PDF </button></a> </td>
                <td><a href="reciveToStock.php?no={{PO.rptPO_no}}" target="_blank"><button class="btn btn-info"><span class="icon ion-android-hand font-weight-bold"></span>&#160;รับสินค้า </button></a> </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>

<script>
    var app = angular.module("showAllPurchaseOrderApp", []);

    app.controller("showAllPurchaseOrderController", function($scope, $http) {
        $scope.getAllPurchaseOrder = function(){

            $http.get('php/getAllPurchaseOrder.php').then(function(res){
                            $scope.POs =res.data.records;
            });
        }
    });
</script>

<script src="dist/sweetalert.min.js"></script>

<?php
if (isset($_GET["no"])){
    $no =$_GET["no"];
    echo "<script> swal('บันทึกข้อมูลเสร็จสิ้น', 'ใบสั่งซื้อเลขที่ $no ', 'success');</script>";
}
?>
</body>
</html>