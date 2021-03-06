<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/11/2018
 * Time: 1:07 PM
 */


if(!isset($_GET["po_no"]) && !isset($_GET["rpo_no"]) ){
    header("Location: purchaseOrderForReceive.php");
}else{
    $po_no = $_GET["po_no"];
    $rpo_no = $_GET["rpo_no"];
}





?>

<!DOCTYPE html>
<html ng-app="receivePurchaseOrderApp" ng-app>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>กรอกรายละเอียดสินค้า</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/lib/angular.min.js"></script>
    <script src="js/lib/popper.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">


</head>

<body>
    <?php
    include 'mainbartest.php';
    /*$role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("21", $allowrule)){
            header("Location: auth.php");
        }*/
    ?>


    <div class="container"  ng-controller="receivePurchaseOrdercontroller" class="ng-scope">
        <br>
        <h3 class="text-center">กรอกรายละเอียดสินค้า</h3>
        <hr>
        <div class="form-group row " ng-init="getHeadReceivePO()">
            <div class="input-group input-group-sm mb-3  col-sm-4">
                <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">เลขที่ใบตรวจรับ</span>
                </div>
                <input type="text" name="rpo_no" ng-model="rpo_no" class="form-control" ng-init="getHeadPurchaseOrder()" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
            </div>
            <div class="input-group input-group-sm mb-3  col-sm-4">
                <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">เลขที่ใบสั่งซื้อ</span>
                </div>
                <input type="text" name="po_no" ng-model="po_no" class="form-control" ng-init="getHeadPurchaseOrder()" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
            </div>
            <div class="input-group input-group-sm mb-3  col-sm-4 ">
                <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">วันที่ตรวจรับ</span>
                </div>
                <input type="date" name="rpo_date" ng-model="rpo_date" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-4">
                <div class="input-group input-group-sm mb-sm-2 ">
                    <input type="hidden" id="cid" name="cid" ng-model="cid">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ผู้ขาย</span>
                    </div>
                    <div class="dropdown">
                        <input type="text" id="cname" name="cname" ng-model="cname" aria-label="Small" aria-describedby="inputGroup-sizing-sm" data-toggle="dropdown" class="form-control dropdown-toggle w-100 " disabled>

                    </div>
                </div>
                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ตัวแทน</span>
                    </div>
                    <input type="text" name="po_agent" ng-model="po_agent" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                </div>
                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ที่อยู่</span>
                    </div>
                    <textarea name="po_lo" ng-model="po_lo" class="form-control" role="2" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled></textarea>
                </div>
                <div class="form-group row">
                    <div class="input-group input-group-sm  col-sm-5">
                        <div class="input-group-prepend ">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">โทร</span>
                        </div>
                        <input type="text" name="po_tel" ng-model="po_tel" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                    </div>
                    <div class="input-group input-group-sm   col-sm-7">
                        <div class="input-group-prepend">
                            <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm">mail</span>
                        </div>
                        <input type="email" name="po_mail" ng-model="po_mail" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">

                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ที่อยู่จัดส่ง</span>
                    </div>
                    <textarea name="po_sendlo" ng-model="po_sendlo" class="form-control" role="2" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled></textarea>
                </div>
                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">กำหนดส่ง</span>
                    </div>
                    <input type="date" name="po_datesend" ng-model="po_datesend" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                </div>

            </div>
        </div>
        <table class="table table-striped" ng-init="getDetailPoProduct()">
            <thead>
            <tr>
                <th>#</th>
                <th>สินค้า</th>
                <th>จำนวนที่สั่ง</th>
                <th>จำนวนที่รับ</th>
                <th>หน่วย</th>
                <th>เลขที่ลอต</th>
                <th>วันหมดอายุ</th>
                <th>barcode</th>

            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="producrPO in producrPOs">
                <td>{{$index + 1}}</td>
                <td>{{producrPO.pname}}</td>
                <td>{{producrPO.remain}}</td>
                <td>{{producrPO.rptRecivePOdetailI_Qty}}</td>
                <td>{{producrPO.type}}</td>
                <td ng-show="checkDetail(producrPO.status_detail)">{{producrPO.lotno}}<input type="number"  class="form-control" name="lotno" ng-model="lotno[$index]"></td>
                <td ng-show="checkDetail(producrPO.status_detail)">{{producrPO.expireday}}<input type="date" class="form-control" name="expireday" ng-model="expireday[$index]"></td>
                <td ng-show="checkDetail(producrPO.status_detail)">{{producrPO.barcode}}<input type="text"  class="form-control" name="barcode" ng-model="barcode[$index]"></td>
                <td ng-show="checkKeyDetail(producrPO.status_detail)"><input type="number"  class="form-control" name="lotno" ng-model="lotno[$index]"></td>
                <td ng-show="checkKeyDetail(producrPO.status_detail)"><input type="date" class="form-control" name="expireday" ng-model="expireday[$index]"></td>
                <td ng-show="checkKeyDetail(producrPO.status_detail)"><input type="text"  class="form-control" name="barcode" ng-model="barcode[$index]"></td>
                <td class="text-center" ng-show="checkKeyDetail(producrPO.status_detail)"><button class="btn btn-success" ng-click="addDetail(producrPO.rptRecivePOdetailI_Id,producrPO.preToStock_id,$index)">บันทึก&#160;<span class="icon ion-android-add-circle font-weight-bold"></span> </button> </td>
                <td class="text-center" ng-show="checkDetail(producrPO.status_detail)"><button class="btn btn-success" ng-click="addDetail(producrPO.rptRecivePOdetailI_Id,producrPO.preToStock_id,$index)" >แก้ไข&#160;<span class="icon ion-edit font-weight-bold"></span> </button> </td>
            </tr>
            </tbody>
        </table>

    </div>
    <script>
    var app = angular.module("receivePurchaseOrderApp", []);

    app.controller("receivePurchaseOrdercontroller", function($scope, $http) {

        $scope.lotno=[];
        $scope.expireday=[];
        $scope.barcode=[];
        $scope.getDetailPoProduct = function(){
            $http.post("php/getDetailReceivePoProduct.php",{
                'po_no':<?=$po_no?>
            }).then(function(response){
                $scope.producrPOs = response.data.records;
            });
        };
        $scope.getHeadReceivePO = function(){
            $http.post("php/getHeadReceivePO.php",{
                'po_no':<?=$po_no?>
            }).then(function(response){
                var temp = angular.fromJson(response.data);
                    $scope.rpo_date = new Date(temp.recieive_Date);

                $scope.po_no = temp.rptPO_no;
                $scope.rpo_no = temp.rptRecivePO_No;
                $scope.cid =  temp.cid;
                $scope.cname =  temp.cname;
                $scope.po_agent =  temp.rptPO_agent;
                $scope.po_lo =  temp.rptPO_lo;
                $scope.po_tel =   temp.rptPO_tel;
                $scope.po_mail =    temp.rptPO_mail ;
                $scope.po_sendlo = temp.rptPO_losend;
                $scope.po_datesend =  new Date(temp.rptPO_datesend);
            })
        };

        $scope.formatDate = function(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        };

        $scope.addDetail = function(rpo_id,preStock_id,index){
            $http.post("php/addDetailProductForReceivePo.php",{
                'rpo_id':rpo_id,
                'preStock_id': preStock_id,
                'lotno':$scope.lotno[index],
                'expireday':$scope.formatDate($scope.expireday[index]),
                'barcode':$scope.barcode[index]
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

                    $scope.getDetailPoProduct();
                    $scope.lotno[index] = $scope.lotno[index];
                    $scope.barcode[index] = $scope.barcode[index];
                    $scope.expireday[index] = new Date( $scope.expireday[index]);
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

                    $scope.getDetailPoProduct();
                }

            });
        };

        $scope.checkDetail = function(status){

            if(status == 0){
                return true;
            }else  {
                return false;
            }

        };



        $scope.checkKeyDetail = function(status){
            console.log(status);
            if(status == 1){
                return true;
            }else  {
                return false;
            }

        };


    });





    </script>
    <script src="dist/sweetalert2.all.js"></script>
</body>

</html>