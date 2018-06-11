

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
                <th>บริษัท</th>
                <th>ตัวแทน</th>
                <th>วันที่สั่ง</th>
                <th>กำหนดส่ง</th>
                <th>สถานะ</th>
            </tr>
            </thead >

            <tbody ng-init="getAllPurchaseOrder()" >
            <tr ng-repeat="PO in POs | orderBy : '-rptPO_no'">
                <td>{{PO.rptPO_no}}</td>
                <td>{{PO.cname}}</td>
                <td>{{PO.rptPO_agent}}</td>
                <td>{{PO.rptPO_date}}</td>
                <td>{{PO.rptPO_datesend}}</td>
                <td>{{PO.rpt_PO_status_desc}}</td>
                <td><a href="reportPurchaseOrder.php?NO={{PO.rptPO_no}}" target="_blank"><button class="btn btn-info" ><span class="icon ion-android-document font-weight-bold"></span>&#160;PDF </button></a> </td>
                <td ng-show="checkStatusAccept(PO.rptPO_status)"><a href="editPurchaseOrder.php?no={{PO.rptPO_no}}"><button class="btn btn-primary" ><span class="icon ion-android-create font-weight-bold"></span>&#160;แก้ไข </button></a> </td>
                <td ng-show="checkStatusAccept(PO.rptPO_status)"><button class="btn btn-success" ng-click="setData(PO.rptPO_no,2)" data-toggle="modal" data-target="#upload"><span class="icon ion-android-checkbox-outline font-weight-bold"></span>&#160;อนุมัติ </button></td>
                <td ng-show="checkStatusReject(PO.rptPO_status)"><button class="btn btn-danger"  ng-click="setData(PO.rptPO_no,3)" data-toggle="modal" data-target="#upload"><span class="icon ion-android-cancel font-weight-bold"></span>&#160;ยกเลิก </button></td>
            </tr>
            </tbody>
        </table>
        <!--modal upload file for accept and receive purchase order-->
        <div class="modal fade" id="upload" tabindex="1" role="dialog">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  font-weight-bold">อัพโหลดเอกสาร</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">

                            <div class="input-group input-group-lg  mb-2">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text icon  ion-android-attach font-weight-bold" >file</span>
                                </div>
                                <input type="file" multiple accept="image/*,.pdf,.PDF" name="file" id="file" ng-model="file" ng-file="uploadfiles" class="form-control"   >
                            </div>

                        </div>
                        <div class="form-group input-group input-group   " ng-show="showNote">
                            <div class="input-group-prepend">
                                <span class="input-group-text  font-weight-bold" id="inputGroup-sizing">หมายเหตุ</span>
                            </div>
                            <textarea name="po_note" rows="10" id="po_note" ng-model="po_note" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-danger" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn  btn-lg btn-success" id="upload" ng-click="upload()" data-dismiss="modal">บันทึก</button>
                    </div>
                </div>
            </div>

        </div>
        <!--end modal upload file for accept nd receive purchase order-->
    </div>
</div>

<script>
    var app = angular.module("showAllPurchaseOrderApp", []);

    app.directive('ngFile', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                element.bind('change', function(){

                    $parse(attrs.ngFile).assign(scope,element[0].files);
                    scope.$apply();
                });
            }
        };
    }]);


    app.controller("showAllPurchaseOrderController", function($scope, $http) {


        $scope.Po_no =null;
        $scope.Flag = null;


        $scope.getAllPurchaseOrder = function(){
            $http.get('php/getAllPurchaseOrder.php').then(function(res){
                            $scope.POs =res.data.records;
            });
        };


        $scope.encryption = function(enc){
            $http.post("php/encode.php",{
                'enc' : enc
            }).then(function(res){
                var temp = angular.fromJson(res.data);
               return temp.enc ;
            })
        };


        $scope.setData  = function(no,flag){
            $scope.Po_no = no;
            $scope.Flag = flag;
            if(parseInt(flag) == 3  ) {
                $scope.showNote = true;
            }else{
                $scope.showNote = false;
            }
        };


        $scope.upload = function(){

            //console.log($scope.Po_no);
            var fd = new FormData();
            angular.forEach($scope.uploadfiles,function(file){
                fd.append('file[]',file);
            });
            fd.append('no',$scope.Po_no);
            fd.append('flag', $scope.Flag);
            if($scope.Flag == 3 ){
                fd.append('note', $scope.po_note);
            }

            $http({
                method: 'post',
                url: 'php/uploadForStatusPO.php',
                data: fd,
                headers: {'Content-Type': undefined},

            }).then(function successCallback(response) {
              if( response.data.records["0"].UpStsrpt_PO == true ){


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
                  $scope.Po_no = null;
                  $scope.Flag = null;
                  $scope.getAllPurchaseOrder();
              }

            });
        };

        $scope.checkStatusAccept = function(status){
           // console.log(status);

            if(parseInt(status) == 1) {

                return true;

            }else{
                return false;
            }
        };


        $scope.checkStatusReject = function(status){
            if(parseInt(status) == 2 || parseInt(status) == 4 ) {

                return true;
            }else{
                return false;
            }
        };

    });
</script>

<script src="dist/sweetalert2.all.js"></script>


</body>
</html>