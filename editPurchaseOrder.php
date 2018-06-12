<?php


     $no = $_GET["no"];


?>


    <!DOCTYPE html>
    <html ng-app="purchaseOrderApp" ng-app>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>สั่งสินค้า</title>
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
        if (!in_array("30", $allowrule)){
            header("Location: auth.php");
        }*/
     ?>
        <div ng-controller="purchaseOrdercontroller" class="ng-scope">
            <div class="container">
                <br>
                <h3 class="text-center">สั่งสินค้า</h3>
                <hr>
                <div class="form-group row ">
                    <div class="input-group input-group-sm mb-3 offset-sm-1 col-sm-5">
                        <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">เลขที่ใบสั่งซื้อ</span>
                        </div>
                        <input type="text" name="po_no" ng-model="po_no" class="form-control" ng-init="getHeadPurchaseOrder()" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                    </div>
                    <div class="input-group input-group-sm mb-3  col-sm-5 ">
                        <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">วันที่</span>
                        </div>
                        <input type="date" name="po_date" ng-model="po_date" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
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
                                <input type="text" id="cname" name="cname" ng-model="cname" ng-init="selectCompany()" aria-label="Small" aria-describedby="inputGroup-sizing-sm" data-toggle="dropdown" class="form-control dropdown-toggle w-100 ">
                                <ul class="dropdown-menu w-100">
                                    <div ng-repeat="company in companys | filter:cname">
                                        <li class="dropdown-item" ng-click="setCompany(company.cid,company.cname,company.agent,company.contact,company.tel,company.mail)"><a>{{company.cname}}</a></li>
                                    </div>
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addcompany"><span class="icon ion-android-contacts font-weight-bold"></span>&#160;เพิ่ม</button>
                        </div>
                        <div class="input-group input-group-sm mb-sm-2 ">
                            <div class="input-group-prepend ">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ตัวแทน</span>
                            </div>
                            <input type="text" name="po_agent" ng-model="po_agent" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-sm-2 ">
                            <div class="input-group-prepend ">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ที่อยู่</span>
                            </div>
                            <textarea name="po_lo" ng-model="po_lo" class="form-control" role="2" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                        </div>
                        <div class="form-group row">
                            <div class="input-group input-group-sm  col-sm-5">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">โทร</span>
                                </div>
                                <input type="text" name="po_tel" ng-model="po_tel" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm   col-sm-7">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm">mail</span>
                                </div>
                                <input type="email" name="po_mail" ng-model="po_mail" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="input-group input-group-sm mb-sm-2 ">
                            <div class="input-group-prepend ">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ที่อยู่จัดส่ง</span>
                            </div>
                            <textarea name="po_sendlo" ng-model="po_sendlo" class="form-control" role="2" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                        </div>
                        <div class="input-group input-group-sm mb-sm-2 ">
                            <div class="input-group-prepend ">
                                <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">กำหนดส่ง</span>
                            </div>
                            <input type="date" name="po_datesend" ng-model="po_datesend" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>

                    </div>
                    <div class="col-sm-4">

                        <div class="form-group row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="vatOp" ng-model="vatOp" id="vatOP" ng-click="discOfPrice()">
                                <label class="form-check-label" for="inlineRadio1">คิดภาษี</label>
                            </div>

                            <div class="input-group input-group-sm col-sm-6 ">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ภาษี</span>
                                </div>
                                <input type="number" min="0" max="100" name="po_vat" ng-model="po_vat" class="form-control" aria-label="Small" ng-change="discOfPrice()" aria-describedby="inputGroup-sizing-sm">
                                <div class="input-group-append">
                                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="disc" ng-model="disc" id="disc" ng-click="discOfPrice()">
                                <label class="form-check-label" for="inlineRadio1">คิดส่วนลด</label>
                            </div>

                            <div class="input-group input-group-sm col-sm-6 ">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ส่วนลด</span>
                                </div>
                                <input type="number" min="0" max="100" name="po_disc" ng-model="po_disc" class="form-control" aria-label="Small" ng-change="discOfPrice()" aria-describedby="inputGroup-sizing-sm">
                                <div class="input-group-append">
                                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group float-right" role="group">

                    <button class="btn btn-success mr-2" ng-click="addToRptPO()">บันทึก&#160;<span class="icon ion-compose font-weight-bold"></span></button>


                    <button class="btn btn-primary " data-toggle="modal" data-target="#selectProductModal">เพิ่มสินค้า&#160;<span class="icon ion-android-add-circle font-weight-bold"></span></button>

                </div>
                <table class="table table-striped" ng-init="getDetailPoProduct()">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>สินค้า</th>
                            <th>จำนวน</th>
                            <th>หน่วย</th>
                            <th>ราคา/หน่วย</th>
                            <th>จำนวนเงิน</th>
                            <th>หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="producrPO in producrPOs">
                            <td>{{$index + 1}}</td>
                            <td>{{producrPO.pname}}</td>
                            <td>{{producrPO.remain}}</td>
                            <td>{{producrPO.type}}</td>
                            <td>{{producrPO.pricePerType}}</td>
                            <td ng-init="sumallprice(producrPO.priceall)"> {{producrPO.priceall}}</td>
                            <td>{{producrPO.note}}</td>
                            <td><button class="btn btn-danger" ng-click="delPoDetail(producrPO.rpt_POD_id)">ลบ&#160;<span class="icon ion-android-remove-circle font-weight-bold"></span> </button> </td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-sm-4 offset-sm-8 border row">
                    <div class="col-7">
                        <p class="font-weight-bold text-right mb-0">รวมเงิน : </p>
                        <p class="font-weight-bold text-right mb-0">ส่วนลด : </p>
                        <p class="font-weight-bold text-right mb-0">หลังหักส่วนลด : </p>
                        <p class="font-weight-bold text-right mb-0">ภาษีมูลค่าเพิม : </p>
                        <p class="font-weight-bold text-right mb-0">จำนวนเงินทั้งสิ้น : </p>
                    </div>
                    <div class="col-5">
                        <p class="mb-0">{{totalprice}}</p>
                        <p class="mb-0">{{discofprice}}</p>
                        <p class="mb-0">{{priceallMidisc}}</p>
                        <p class="mb-0">{{vatofprice}}</p>
                        <p class="mb-0">{{totalPAll}}</p>

                    </div>
                </div>

                <div class="form-group input-group input-group   ">
                    <div class="input-group-prepend">
                        <span class="input-group-text  font-weight-bold" id="inputGroup-sizing">หมายเหตุ</span>
                    </div>
                    <textarea name="po_note" rows="5" id="po_note" ng-model="po_note" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing"></textarea>
                </div>

                <!--..................................modal add detail product start........................................-->
                <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="prestockModalLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered" role="document">
                        <div class="modal-content">


                            <div class="modal-header">
                                <h5 class="modal-title" id="prestockModalLabel">สินค้า : {{po_pname}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="form-group row">

                                        <div class="form-group row">
                                            <div class="input-group input-group-sm  col-sm-6">
                                                <div class="input-group-prepend ">
                                                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">จำนวน</span>
                                                </div>
                                                <input type="number" min="0" name="po_remain" id="po_remain" ng-model="po_remain" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                            </div>
                                            <div class="input-group input-group-sm   col-sm-6">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm">หน่วย</span>
                                                </div>
                                                <input type="text" name="po_type" id="po_type" ng-model="po_type" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="input-group input-group-sm   col-sm-12">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm">ราคาต่อหน่วย</span>
                                                </div>
                                                <input type="text" name="po_pricePerType" id="po_pricePerType" ng-model="po_pricePerType" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                            </div>

                                        </div>

                                        <div class="form-group input-group input-group-sm   ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm">หมายเหตุ</span>
                                            </div>

                                            <textarea name="po_notePro" rows="5" id="po_notePro" ng-model="po_notePro" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                                            <!--<input type="text" name="po_discount" id="po_discount" ng-model="po_discount" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">-->
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-success" ng-click="addToPoDetail()" data-dismiss="modal">เพิ่ม</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!--..................................end modal add detail product start........................................-->
                <!--..................................modal selectProกduct start........................................-->
                <div class="modal fade" id="selectProductModal" tabindex="-1" role="dialog" aria-labelledby="prestockModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="prestockModalLabel">เลือกสินค้า</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                            </div>
                            <div class="modal-body ">

                                <div class="container mb-0">
                                    <div class="row">
                                        <div class="col-md-2">PageSize:
                                            <select ng-model="entryLimit" class="form-control">
                                            <option>5</option>
                                            <option>10</option>
                                            <option>20</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                        </div>
                                        <div class="col-md-3">Filter:
                                            <input type="text" ng-model="search" ng-change="filter()" placeholder="Filter" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Filtered {{ filtered.length }} of {{ totalItems}} total product</h5>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12" ng-show="filteredItems > 0">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th><a ng-click="sort_by('pname');">ชื่อสินค้า</a></th>


                                                </thead>
                                                <tbody ng-init="getProduct()">
                                                    <tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
                                                        <td>{{data.pname}}</td>

                                                        <td><button class="btn btn-info" ng-click="selectProduct(data.regno,data.pname)" data-dismiss="modal" data-toggle="modal" data-target="#addProductModal">เลือก</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12" ng-show="filteredItems == 0">
                                            <div class="col-md-12">
                                                <h4>No product found</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-12" ng-show="filteredItems > 0">
                                            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--..................................end modal selectProกduct start........................................-->


                <!--modal add company-->
                <div class="modal fade" id="addcompany" tabindex="1" role="dialog">
                    <div class="modal-dialog  modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title  font-weight-bold">เพิ่มบริษัท</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">

                                    <div class="input-group input-group-sm  mb-2">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ชื่อบริษัท</span>
                                        </div>
                                        <input type="text" name="acname" id="acname" ng-model="acname" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="input-group input-group-sm  mb-2">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ตัวแทน</span>
                                        </div>
                                        <input type="text" name="agent" id="agent" ng-model="agent" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="input-group input-group-sm mb-2 ">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">ที่อยู่</span>
                                        </div>
                                        <input type="text" name="contact" id="contact" ng-model="contact" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="input-group input-group-sm  mb-2">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">เบอร์โทร</span>
                                        </div>
                                        <input type="text" name="tel" id="tel" ng-model="tel" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="input-group input-group-sm  ">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">E-mail</span>
                                        </div>
                                        <input type="text" name="mail" id="mail" ng-model="mail" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-danger" data-dismiss="modal">ยกเลิก</button>
                                <button class="btn  btn-lg btn-success" ng-click="addCompany()">บันทึก</button>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end modal add company-->






            </div>
        </div>

        <script>
            var app = angular.module("purchaseOrderApp", []);

            app.filter('startFrom', function() {
                return function(input, start) {
                    if (input) {
                        start = +start; //parse to int
                        return input.slice(start);
                    }
                    return [];
                }
            });

            app.controller('purchaseOrdercontroller', function($scope, $http, $timeout) {

                $scope.po_discount = 0;
                $scope.countPro = 0;

                $scope.po_vat = 0;
                $scope.po_disc = 0;
                $scope.discofprice = 0.00;
                $scope.totalprice = 0.00;
                $scope.vatofprice = 0.00;
                $scope.priceallMidisc = 0.00;
                $scope.totalPAll = 0.00;

                var ttprice = 0.00;
                var po_productid = null;
                $scope.sumallprice = function(allprice) {


                    $scope.totalprice = parseFloat(parseFloat($scope.totalprice) + parseFloat(allprice)).toFixed(2);

                    $scope.discOfPrice();
                };
                $scope.setPage = function(pageNo) {
                    $scope.currentPage = pageNo;
                };
                $scope.filter = function() {
                    $timeout(function() {
                        $scope.filteredItems = $scope.filtered.length;
                    }, 10);
                };
                $scope.sort_by = function(predicate) {
                    $scope.predicate = predicate;
                    $scope.reverse = !$scope.reverse;
                };
                $scope.selectProduct = function(id, name) {

                    $scope.po_pname = name;
                    po_productid = id;

                };
                $scope.addToPoDetail = function() {


                    if ($scope.po_remain == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกจำนวนสินค้า", "warning");
                        return;
                    }
                    if ($scope.po_type == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกหน่วยสินค้า", "warning");
                        return;
                    }
                    if ($scope.po_pricePerType == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกราคาต่อหน่วย", "warning");
                        return;
                    }

                    if ($scope.po_notePro == null) {
                        $scope.po_notePro = "-";
                    }




                    $http.post('php/addToPoDetail.php', {
                        'no': <?= sprintf("%'.010d",$no )?>,
                        'po_productid': po_productid,
                        'po_remain': $scope.po_remain,
                        'po_type': $scope.po_type,
                        'po_pricePerType': $scope.po_pricePerType,
                        'po_notePro': $scope.po_notePro
                    }).then(function(res) {
                        if (res.data.add == true) {
                            const toast = swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            toast({
                                type: 'success',
                                title: 'เพิ่มสินค้าสำเร็จ'
                            });
                            po_productid = null;
                            $scope.po_remain = null;
                            $scope.po_type = null;
                            $scope.po_pricePerType = null;
                            $scope.po_notePro = null;
                            $scope.totalprice = 0.00;

                            $scope.getDetailPoProduct();
                        } else {
                            const toast = swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            toast({
                                type: 'error',
                                title: 'เพิ่มสินค้าไม่สำเร็จ'
                            });
                            po_productid = null;
                            $scope.po_remain = null;
                            $scope.po_type = null;
                            $scope.po_pricePerType = null;
                            $scope.po_notePro = null;
                            $scope.totalprice = 0.00;

                            $scope.getDetailPoProduct();
                        }
                    });
                };
                $scope.selectPrePO = function() {
                    $http.get('php/selelctPrePO.php').then(function(res) {

                        $scope.producrPOs = res.data.records

                    })
                };
                $scope.delPoDetail = function(id) {

                    swal({


                            type: 'warning',
                            title: 'ลบข้อมูล',
                            text: 'ต้องการลบข้อมูลหรือไม่',
                            allowOutsideClick: false,
                            allowEnterKey: true,
                            showConfirmButton: true,
                            showCancelButton: true
                        })
                        .then((data) => {
                            if (data.value) {

                                $http.post('php/delPoDetail.php', {
                                    'id': id
                                }).then(function(res) {
                                    var temp = res.data;
                                    if (temp.del == true) {
                                        const toast = swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });

                                        toast({
                                            type: 'success',
                                            title: 'ลบสินค้าสำเร็จ'
                                        });
                                        $scope.totalprice = 0.00;

                                        $scope.getDetailPoProduct();
                                    } else {
                                        const toast = swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });

                                        toast({
                                            type: 'error',
                                            title: 'ลบสินค้าไม่สำเร็จ'
                                        });
                                        $scope.totalprice = 0.00;
                                        $scope.getDetailPoProduct();
                                    }
                                });

                            }
                        });

                };
                $scope.genPO_NO = function() {
                    $http.get('php/genPO_NO.php').then(function(res) {
                        $scope.po_no = res.data.records[0].rptPO_no;
                        $scope.no = res.data.records[0].rptPO_no;
                    });
                };

                $scope.getHeadPurchaseOrder = function() {

                    $http.post("php/getHeadEditPurchaseOrder.php", {
                        'no': <?= sprintf("%'.010d",$no )?>
                    }).then(function(res) {

                        var temp = angular.fromJson(res.data);

                        $scope.po_no = temp.rptPO_no;

                        $scope.cid = temp.cid;
                        $scope.cname = temp.cname;
                        $scope.po_agent = temp.rptPO_agent;
                        $scope.po_lo = temp.rptPO_lo;
                        $scope.po_tel = temp.rptPO_tel;
                        $scope.po_mail = temp.rptPO_mail;




                        $scope.po_sendlo = temp.rptPO_losend;
                        $scope.po_note = temp.note;

                        $scope.countPro = 0;
                        $scope.po_date = new Date(temp.rptPO_date);
                        $scope.po_datesend = new Date(temp.rptPO_datesend);
                        $scope.po_vat = temp.vat;
                        $scope.po_disc = temp.discount;
                        // $scope.discofprice = temp.pricediscount;
                        // $scope.totalprice = temp.pricesum;
                        //  $scope.vatofprice = temp.pricevat;
                        // $scope.priceallMidisc = temp.priceMIdicount;
                        //$scope.totalPAll = temp.totalprice;

                    })

                };
                $scope.getDetailPoProduct = function() {
                    $http.post("php/getDetailPoProduct.php", {
                        'no': <?= sprintf("%'.010d",$no )?>
                    }).then(function(res) {
                        $scope.producrPOs = res.data.records
                        $scope.discOfPrice();
                    })
                };



                $scope.selectCompany = function() {
                    $http.get("php/companySelect.php").then(function(response) {
                        $scope.companys = response.data.records;
                    });
                };
                $scope.setCompany = function(id, name, agent, conn, tel, mail) {
                    $scope.cid = null;
                    $scope.cname = null;
                    $scope.po_agent = null;
                    $scope.po_lo = null;
                    $scope.po_tel = null;
                    $scope.po_mail = null;
                    $scope.cid = id;
                    $scope.cname = name;
                    $scope.po_agent = agent;
                    $scope.po_lo = conn;
                    $scope.po_tel = tel;
                    $scope.po_mail = mail;

                };
                $scope.discOfPrice = function() {
                    if (($scope.po_disc > 100 && $scope.po_disc < 0) || $scope.po_disc == null) {
                        $scope.po_disc = 0;
                    }

                    if (($scope.vatOp > 100 && $scope.vatOp < 0) || $scope.vatOp == null) {
                        $scope.vatOp = 0;
                    }
                    // if ($scope.disc) {
                    $scope.discofprice = parseFloat($scope.totalprice * $scope.po_disc / 100).toFixed(2);
                    $scope.priceallMidisc = parseFloat($scope.totalprice - $scope.discofprice).toFixed(2);

                    /*} else {
                        $scope.discofprice = 0.00;
                        $scope.priceallMidisc = parseFloat($scope.totalprice - $scope.discofprice).toFixed(2);

                    }*/

                    //if ($scope.vatOp) {

                    $scope.vatofprice = parseFloat($scope.priceallMidisc * $scope.po_vat / 100).toFixed(2);
                    /*} else {
                        $scope.vatofprice = 0.00;
                    }*/

                    $scope.totalPAll = parseFloat(parseFloat($scope.priceallMidisc) + parseFloat($scope.vatofprice)).toFixed(2);

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
                $scope.addToRptPO = function() {


                    var date1 = new Date($scope.po_date);
                    var date2 = new Date($scope.po_datesend);




                    if ($scope.cid == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกบริษัทคู่ค้า", "warning");

                        return;
                    }

                    if ($scope.po_agent == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกตัวแทน", "warning");

                        return;
                    }
                    if ($scope.po_lo == null) {
                        $scope.po_lo = "-";
                    }
                    if ($scope.po_tel == null) {
                        $scope.po_tel = "-";
                    }
                    if ($scope.po_mail == null) {
                        $scope.po_mail = "-";
                    }

                    if ($scope.po_sendlo == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกตที่อยู่จัดส่ง", "warning");

                        return;
                    }
                    if ($scope.po_datesend == null) {
                        date2 = "0000/00/00"
                    }
                    if ($scope.po_note == null) {
                        $scope.po_note = "-";
                    }


                    if ($scope.po_vat != 0 && $scope.vatOp == false) {
                        $scope.vatOp = true;
                        $scope.discOfPrice();
                    }

                    if ($scope.po_disc != 0 && $scope.disc == false) {
                        $scope.disc = true;
                        $scope.discOfPrice();
                    }


                    $http.post('php/editRptPO.php', {
                        'po_no': $scope.po_no,
                        'po_date': $scope.formatDate(date1),
                        'cid': $scope.cid,
                        'po_agent': $scope.po_agent,
                        'po_lo': $scope.po_lo,
                        'po_tel': $scope.po_tel,
                        'po_mail': $scope.po_mail,
                        'discount': $scope.po_disc,
                        'po_sendlo': $scope.po_sendlo,
                        'po_datesend': $scope.formatDate(date2),
                        'pricesum': $scope.totalprice,
                        'pricediscount': $scope.discofprice,
                        'priceMIdicount': $scope.priceallMidisc,
                        'vat': $scope.po_vat,
                        'pricevat': $scope.vatofprice,
                        'totalprice': $scope.totalPAll,
                        'note': $scope.po_note
                    }).then(function(res) {
                        var temp = angular.fromJson(res.data);
                        //console.log(temp.addrpt_PO ,temp.addrpt_POD,temp.DelPrePO);
                        if (temp.records["0"].Uprpt_PO == true) {
                            $scope.selectPrePO();
                            $scope.cname = null;
                            $scope.cid = null;
                            $scope.po_agent = null;
                            $scope.po_lo = null;
                            $scope.po_tel = null;
                            $scope.po_mail = null;

                            $scope.po_sendlo = null;
                            $scope.po_note = null;
                            $scope.po_discount = 0;
                            $scope.countPro = 0;
                            $scope.po_date = new Date();
                            $scope.po_datesend = new Date();
                            $scope.po_vat = 7;
                            $scope.po_disc = 0;
                            $scope.discofprice = 0.00;
                            $scope.totalprice = 0.00;
                            $scope.vatofprice = 0.00;
                            $scope.priceallMidisc = 0.00;
                            $scope.totalPAll = 0.00;
                            swal({
                                type: 'success',
                                title: 'บันทึกข้อมูลเสร็จสิ้น',
                                text: 'บันทึกข้อมูลแล้ว',
                                allowOutsideClick: false,
                                allowEnterKey: true,
                                showConfirmButton: true
                            }).then((resolve) => {
                                window.location.assign("showAllPurchaseOrder.php");
                                if (resolve.value) {
                                    window.location.assign("showAllPurchaseOrder.php");
                                }
                            })
                        }


                    });


                };
                $scope.getProduct = function() {
                    $http.get('php/pselect.php').then(function(res) {
                        $scope.list = res.data.records;
                        $scope.currentPage = 1; //current page
                        $scope.entryLimit = 5; //max no of items to display in a page
                        $scope.filteredItems = $scope.list.length; //Initially for no filter
                        $scope.totalItems = $scope.list.length;
                    });
                };

                $scope.addCompany = function() {

                    if ($scope.acname == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกชื่อบริษัท", "warning");
                        return;
                    }
                    if ($scope.agent == null) {
                        swal("เกิดข้อผิดพลาด", "ไม่ได้กรอกตัวแทน", "warning");
                        return;
                    }
                    if ($scope.contact == null) {
                        $scope.contact = "-";
                    }
                    if ($scope.tel == null) {
                        $scope.tel = "-";
                    }
                    if ($scope.mail == null) {
                        $scope.mail = "-";
                    }




                    $http.post('php/addCompany.php', {
                        'cname': $scope.acname,
                        'agent': $scope.agent,
                        'contact': $scope.contact,
                        'tel': $scope.tel,
                        'mail': $scope.mail
                    }).then(function(res) {
                        var temp = angular.fromJson(res.data);
                        if (temp.Insert == true) {
                            swal("บันทึกข้อมูลเสร็จสิ้น", "บันทึกข้อมูลแล้ว", "success");
                            $scope.cid = temp.cid;
                            $scope.cname = $scope.acname;
                            $scope.po_agent = $scope.agent;
                            $scope.po_lo = $scope.contact;
                            $scope.po_tel = $scope.tel;
                            $scope.po_mail = $scope.mail;
                            $scope.acname = null;
                            $scope.agent = null;
                            $scope.contact = null;
                            $scope.tel = null;
                            $scope.mail = null;
                        }
                    });
                };

                $scope.test = function() {};
            });

        </script>
        <script src="dist/sweetalert2.all.js"></script>
        <script type="application/javascript">


        </script>
    </body>

    </html>