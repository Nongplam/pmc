<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>รับสินค้าเข้าคลังสาขา</title>
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
        if (!in_array("20", $allowrule)){
            header("Location: auth.php");
        }
     ?>


<div ng-app="reciveBranchStockApp" ng-controller="reciveBranchStockcontroller"  class="ng-scope">
    <div class=" container">
    <br>
    <h3 align="center">รับสินค้าเข้าคลังสาขา</h3>
    <hr>

    <div class="form-group row">
        <label for="sTbs_no" class="col-sm-2 col-form-label font-weight-bold text-right">รหัสใบส่ง : </label>
        <div class="col-sm-7">
           <input name="sTbs_no" ng-model="sTbs_no" class="form-control"/>
        </div>
        <div class="col-sm-2">

            <button class="btn btn-danger btn-xs" ng-click="searchReciveBranchStock()"><span class="icon ion-search"></span></button>
        </div>
    </div>


    <table class="table">
        <thead>
            <tr class="d-flex">
                <th class="col-2">รหัสสินค้า</th>
                <th class="col-4">ชื่อ</th>
                <th class="col-1 text-center">จำนวน</th>
                <th class="col-2 text-center">หน่วย</th>
                <th class="col-2 text-center">รับสินค้า</th>
            </tr>
        </thead>
        <tbody>
            <tr class="d-flex" ng-repeat="sTbs in sTbss">
                <td class="col-2">{{sTbs.productid}}</td>
                <td class="col-4">{{sTbs.pname}}</td>
                <td class="col-1 text-center">{{sTbs.rptsTbs_qty}}</td>
                <td class="col-2 text-center">{{sTbs.stocktype}}</td>
                <td class="col-2 text-center"><button class="btn btn-primary" data-toggle="modal" data-target="#reciveModal" ng-click="reciveToStockModal(sTbs.stockid,sTbs.pname,sTbs.rptsTbs_qty,sTbs.stocktype)">รับ</button></td>
            </tr>
        </tbody>
    </table>




        <!--..................................modal addtpre start........................................-->
        <div class="modal fade" id="reciveModal" tabindex="-1" role="dialog" aria-labelledby="prestockModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prestockModalLabel">เพิ่มสต็อค</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modalform">
                            <div class="container">
                                <div class="row">
                                    <h5>ชื่อ :&nbsp; {{pnameonmodal}}</h5>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="message-text" class="col-sm-2 col-form-label">จำนวน:</label>
                                <div class="col-sm-5">
                                    <input type="number" min="0" step="1" class="form-control" ng-model="stockqtyonmodal">
                                </div>
                                <label for="message-text" class="col-sm-1 col-form-label" ng-bind="typeonmodal"></label>
                                <input type="hidden" id="stockid" ng-model="stockid">

                            </div>



                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-success" ng-click="addToStock()" data-dismiss="modal">เพิ่มสต็อค</button>
                    </div>
                </div>
            </div>
        </div>
        <!--......................................endmodal...................................-->







    </div>
</div>
<script>
    var app = angular.module("reciveBranchStockApp", []);

    app.controller("reciveBranchStockcontroller", function($scope, $http) {
        var rptsTbsNo ;
        $scope.searchReciveBranchStock = function(){
                if($scope.sTbs_no == null){
                    return false
                }
            rptsTbsNo = $scope.sTbs_no;
            $http.post('php/getSendStockToBranchStockBysTbs_no.php',{
                'sTbs_no':$scope.sTbs_no
            }).then(function(res){
                $scope.sTbss = res.data.records;
            });

        }

        $scope.reciveToStockModal  = function(sid,pname,qty,type){
             $scope.pnameonmodal = pname ;
            $scope.stockqtyonmodal=      parseInt(qty);
            $scope.typeonmodal = type;
            $scope.stockid =sid;
        }


        $scope.addToStock =function(){


            $http.post('php/addToBranchStock.php',{
                'rptsTbsNo': rptsTbsNo ,
                'stockid': $scope.stockid,
                'qty':$scope.stockqtyonmodal
            }).then(function(res){

                $scope.searchReciveBranchStock();

            });


        }


    });

</script>





</body>
</html>