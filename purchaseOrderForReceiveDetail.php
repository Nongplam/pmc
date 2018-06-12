<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/6/2018
 * Time: 4:36 PM
 */
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>รายการกรอกรายละเอียด</title>
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
    
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("35", $allowrule)){
            header("Location: auth.php");
        }
     ?>

            <div ng-app="showAllPurchaseOrderApp" ng-controller="showAllPurchaseOrderController" class="ng-scope">
                <div class=" container">
                    <br>
                    <h3 align="center">รายการกรอกรายละเอียด</h3>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr class="table-info">
                                <th>เลขที่ใบสั่งซื้อ</th>
                                <th>บริษัท</th>
                                <th>ตัวแทน</th>
                                <th>วันที่สั่ง</th>
                                <th>กำหนดส่ง</th>
                                <th>สถานะใบสั่ง</th>
                                <th>เลขที่ใบตรวจรับ</th>
                                <!-- <th>สถานะใบตรวจรับ</th>-->
                                <td>วันที่ออกใบตรวจรับ</td>
                            </tr>
                        </thead>

                        <tbody ng-init="getAllPurchaseOrder()">
                            <tr ng-repeat="PO in POs | orderBy : '-rptPO_no'" ng-show="checkStatus(PO.rptPO_status)">
                                <td>{{PO.rptPO_no}}</td>
                                <td>{{PO.cname}}</td>
                                <td>{{PO.rptPO_agent}}</td>
                                <td>{{PO.rptPO_date}}</td>
                                <td>{{PO.rptPO_datesend}}</td>
                                <td>{{PO.rpt_PO_status_desc}}</td>
                                <td>{{PO.rptRecivePO_No}}</td>
                                <!-- <td>{{PO.rptRecivePO_Status}}</td>-->
                                <td>{{PO.rptRecivePO_Date}}</td>
                                <td> <a ng-show="checkStatusKeyRemain(PO.rptPO_status,PO.rptRecivePO_Status)" href="receivePurchaseOrderDetail.php?po_no={{PO.rptPO_no}}&&rpo_no={{PO.rptRecivePO_No}}" target="_blank"><button class="btn btn-info mb-2 mr-2"><span class="icon ion-clipboard font-weight-bold"></span>&#160;กรอกรายละเอียด </button></a> </td>
                            </tr>
                        </tbody>
                    </table>

                </div>



            </div>




            <script>
                var app = angular.module("showAllPurchaseOrderApp", []);

                app.directive('ngFile', ['$parse', function($parse) {
                    return {
                        restrict: 'A',
                        link: function(scope, element, attrs) {
                            element.bind('change', function() {

                                $parse(attrs.ngFile).assign(scope, element[0].files);
                                scope.$apply();
                            });
                        }
                    };
                }]);

                app.controller("showAllPurchaseOrderController", function($scope, $http) {
                    $scope.getAllPurchaseOrder = function() {

                        $http.get('php/getAllPurchaseOrder.php').then(function(res) {
                            $scope.POs = res.data.records;
                        });
                    };

                    $scope.setData = function(no) {
                        $scope.Po_no = no;

                    };

                    $scope.upload = function() {
                        //console.log("runqqqqqqq");
                        //console.log($scope.Po_no);
                        var fd = new FormData();
                        angular.forEach($scope.uploadfiles, function(file) {
                            fd.append('file[]', file);
                        });
                        fd.append('no', $scope.Po_no);



                        $http({
                            method: 'post',
                            url: 'php/uploadForCompletePurchaseOrder.php',
                            data: fd,
                            headers: {
                                'Content-Type': undefined
                            },

                        }).then(function successCallback(response) {
                            if (response.data.records["0"].UpStsrpt_PO == true) {


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
                                $scope.uploadfiles = null;
                                $scope.file = null;
                                $scope.getAllPurchaseOrder();
                            }

                        });
                    };

                    $scope.reciveProduct = function(po_no) {

                        swal({
                            title: 'กรอกรหัสผ่าน',
                            input: 'password',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'ตกลง',
                            cancelButtonText: 'ยกเลิก',
                            showLoaderOnConfirm: true,
                            preConfirm: (pass) => {
                                return $http.post('php/checkAuthorityReceiveProduct.php', {
                                    'pass': pass,
                                    'po_no': po_no
                                }).then(function(response) {
                                    return response.data.records
                                }).catch(function(error) {
                                    swal.showValidationError(
                                        'Request failed: ' + error
                                    )
                                });
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        }).then((result) => {
                            if (result.value) {

                                swal({
                                    title: `${result.value["0"].userid}'s avatar`,

                                })

                            }
                        })
                    };




                    $scope.checkStatus = function(status) {
                        if (status == 5) {
                            return true;
                        } else {
                            return false;
                        }
                    };


                    $scope.createReceivePurchaseOrder = function(po_no) {


                        $http.post("php/createReceivePurchaseOrder.php", {
                            'po_no': po_no
                        }).then(function(response) {
                            if (response.data.Insert == true) {
                                const toast = swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                toast({
                                    type: 'success',
                                    title: 'สร้างใบตรวจรับเเรียบร้อย'
                                });

                                $scope.getAllPurchaseOrder();
                            } else {
                                const toast = swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                toast({
                                    type: 'error',
                                    title: 'สร้างใบสั่งผิดพลาก'
                                });

                                $scope.getAllPurchaseOrder();
                            }
                        })
                    };


                    $scope.checkStatusCreateReceivePurchaseOrder = function(status) {
                        if (status == 2) {
                            return true;
                        } else {
                            return false;
                        }
                    };



                    $scope.checkStatusCompleteReceivePurchaseOrder = function(status) {
                        if (status == 4) {
                            return true;
                        } else {
                            return false;
                        }
                    };


                    $scope.checkStatusKeyRemain = function(status1, status2) {
                        if (status1 == 5 || status2 == 1) {
                            return true;
                        } else {
                            return false;
                        }
                    };

                });

            </script>

            <script src="dist/sweetalert2.all.js"></script>


    </body>

    </html>
