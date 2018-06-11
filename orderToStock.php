<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 8:18 PM
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>รายการรอโอนย้ายเข้าคลัง</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.0/dist/promise.min.js"></script>
</head>
<body>
<?php
include 'mainbartest.php';
/*
$role=$_SESSION["role"];
$allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
$allowqueryresult=mysqli_query($con,$allowquery);
$allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);
$allowrule = explode(",",$allowruleraw["rule"]);
    if (!in_array("22", $allowrule)){
        header("Location: auth.php");
    }*/
?>
<div ng-app="orderToStockApp" ng-controller="orderToStockController"  class="ng-scope">
    <div class=" container">
        <br>
        <h3 align="center">รายการรอโอนย้ายเข้าคลัง</h3>
        <hr>

        <table class="table table-bordered table-striped" ng-init="gerOrders()">
            <thead>
            <tr>
                <th>#</th>
                <th>เลขที่ใบสั่งซื้อ</th>
                <th>เลขที่ใบตรวจรับ</th>
                <th>วันที่ตรวจรับ</th>
                <th>สถานะกรอกจำนวน</th>
                <th>สถานะกรอกรายละเอียด</th>
                <th>สถานะกรอกราคา</th>

            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="order in orders">
                <td>{{$index + 1}}</td>
                <td>{{order.rptPO_no}}</td>
                <td>{{order.rptRecivePO_No}}</td>
                <td>{{order.recieive_Date}}</td>
                <td>{{checkRemain(order.status_remain)}}</td>
                <td>{{checkDetail(order.status_detail)}}</td>
                <td>{{checkPrice(order.status_price)}}</td>
                <td ng-show="checkCompleteOrder(order.status_remain,order.status_detail,order.status_price)"><button class="btn btn-success " ng-click="transferToStock(order.rptPO_no)"><span class="icon ion-play font-weight-bold"></span>&#160;โอนเข้าคลัง</button> </td>
            </tr>
            </tbody>
        </table>






    </div>
</div>
<script>
    var app = angular.module("orderToStockApp", []);

    app.controller("orderToStockController", function($scope, $http) {


        $scope.gerOrders = function(){
        $http.post("php/getOrderToStock.php").then(function(response){
                $scope.orders =  response.data.records;
                $scope.gerOrders();
            });
        };

        $scope.checkRemain = function(status){

            if(status == 0){
                return "เรียบร้อย";
            }else  {
                return "ยังไม่เรียบร้อย";
            }

        };

        $scope.checkDetail = function(status){

            if(status == 0){
                return "เรียบร้อย";
            }else  {
                return "ยังไม่เรียบร้อย";
            }

        };
        $scope.checkPrice = function(status){

            if(status == 0){
                return "เรียบร้อย";
            }else  {
                return "ยังไม่เรียบร้อย";
            }

        };


        $scope.checkCompleteOrder = function(status1,status2,status3){
            if(status1 == 0 && status2 == 0 && status3 == 0) {
                return true;
            }else{
                return false;
            }
        };


        $scope.transferToStock = function(no){
            $http.post("php/transferToStock.php",{
                'po_no': no
            }).then(function(response){
                if(response.data.Insert == true){
                    const toast = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    toast({
                        type: 'success',
                        title: 'บันทึกสำเร็จ'
                    });
                    $scope.gerOrders();
                }else{
                    const toast = swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    toast({
                        type: 'error',
                        title: 'บันทึกผิดพลาด'
                    });

                    $scope.gerOrders();
                }
            });
        };
    });



</script>
<script src="dist/sweetalert2.all.js"></script>




</body>
</html>*
