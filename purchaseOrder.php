<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>สั่งสินค้า</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>

</head>
<body>
<div ng-app="purchaseOrderApp" ng-controller="purchaseOrdercontroller"  class="ng-scope">
    <div class="container">
        <h3 class="text-center">สั่งสินค้า</h3>
        <hr>
        <div class="form-group row ">
            <div class="input-group input-group-sm mb-3 offset-sm-1 col-sm-5">
                <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >เลขที่ใบสั่งซื้อ</span>
                </div>
                <input type="text" name="po_no" ng-model="po_no" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
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
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >ผู้ขาย</span>
                    </div>
                    <input type="text" name="po_saler" ng-model="po_saler" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                </div>
                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >ตัวแทน</span>
                    </div>
                    <input type="text" name="po_agent" ng-model="po_agent" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                </div>
                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >ที่อยู่</span>
                    </div>
                    <textarea name="po_lo" ng-model="po_lo" class="form-control" role="2"  aria-label="Small" aria-describedby="inputGroup-sizing-sm" ></textarea>
                </div>
                <div class="form-group row">
                    <div class="input-group input-group-sm  col-sm-5">
                        <div class="input-group-prepend ">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >โทร</span>
                        </div>
                        <input type="text" name="po_tel" ng-model="po_tel" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                    </div>
                    <div class="input-group input-group-sm   col-sm-7">
                        <div class="input-group-prepend">
                            <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm" >mail</span>
                        </div>
                        <input type="email" name="po_mail" ng-model="po_mail" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend">
                        <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm" >เลขที่ใบกำกับภาษี</span>
                    </div>
                    <input type="text" name="po_vatno" ng-model="po_vatno" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                </div>

                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >ที่อยู่จัดส่ง</span>
                    </div>
                    <textarea name="po_sendlo" ng-model="po_sendlo" class="form-control" role="2"  aria-label="Small" aria-describedby="inputGroup-sizing-sm" ></textarea>
                </div>
                <div class="input-group input-group-sm mb-sm-2 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >กำหนดส่ง</span>
                    </div>
                    <input type="date" name="po_datesend" ng-model="po_datesend" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                </div>

            </div>
            <div class="col-sm-4">
                <div class="form-group row">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="vatOp" ng-model="vatOp" id="inlineRadio1" value="1" checked>
                        <label class="form-check-label" for="inlineRadio1">คิดภาษี</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="vatOp" ng-model="vatOp" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">ไม่คิดภาษี</label>
                    </div>
                    <div class="input-group input-group-sm col-sm-6 ">
                        <div class="input-group-prepend ">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >ภาษี</span>
                        </div>
                        <input type="text" name="po_vat" ng-model="po_vat" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                        <div class="input-group-append">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                    <th>#</th>
                    <th>สินค้า</th>
                    <th>จำนวน</th>
                    <th>หน่วย</th>
                    <th>ราคา/หน่วย</th>
                    <th>ส่วนลด</th>
                    <th>จำนวนเงิน</th>
                </thead>
                <tbody>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tbody>
            </table>

        </div>





    </div>
</div>


<script>
    var app = angular.module("purchaseOrderApp", []);

    app.controller("purchaseOrdercontroller", function($scope, $http){
        $scope.po_date = new Date();
        $scope.po_vat  = 7;
       // $scope.vatOp = 1;


    });

</script>
</body>
</html>