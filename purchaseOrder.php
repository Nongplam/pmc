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
<div  ng-controller="purchaseOrdercontroller"  class="ng-scope">
    <div class="container">
        <h3 class="text-center">สั่งสินค้า</h3>
        <hr>
        <div class="form-group row ">
            <div class="input-group input-group-sm mb-3 offset-sm-1 col-sm-5">
                <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >เลขที่ใบสั่งซื้อ</span>
                </div>
                <input type="text" name="po_no" ng-model="po_no" class="form-control" ng-init="genPO_NO()" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
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
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >ผู้ขาย</span>
                        </div>
                    <div class="dropdown">
                        <input type="text" id="cname" name="cname" ng-model="cname" ng-init="selectCompany()" aria-label="Small" aria-describedby="inputGroup-sizing-sm" data-toggle="dropdown" class="form-control dropdown-toggle w-100 ">
                        <ul class="dropdown-menu w-100">
                            <div ng-repeat="company in companys | filter:cname">
                                <li class="dropdown-item" ng-click="setCompany(company.cid,company.cname)"><a>{{company.cname}}</a></li>
                            </div>
                        </ul>
                    </div>

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
                        <input class="form-check-input" type="checkbox" name="vatOp" ng-model="vatOp" id="vatOP">
                        <label class="form-check-label" for="inlineRadio1">คิดภาษี</label>
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
                <div class="form-group row">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="disc" ng-model="disc" id="disc" >
                        <label class="form-check-label" for="inlineRadio1">คิดส่วนลด</label>
                    </div>

                    <div class="input-group input-group-sm col-sm-6 ">
                        <div class="input-group-prepend ">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >ส่วนลด</span>
                        </div>
                        <input type="text" name="po_disc" ng-model="po_disc" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" >
                        <div class="input-group-append">
                            <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm">%</span>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="btn-group offset-sm-9" role="group" >
                <button class="btn btn-success mr-2" ng-click="" >สั่งสินค้า &#160;<span class="icon ion-android-checkbox-outline font-weight-bold"></span></button>

                <button class="btn btn-primary "  data-toggle="modal" data-target="#selectProductModal">เพิ่มสินค้า&#160;<span class="icon ion-android-add-circle font-weight-bold"></span></button>

        </div>
            <table class="table table-striped" ng-init="selectPrePO()">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>หน่วย</th>
                        <th>ราคา/หน่วย</th>
                        <th>ส่วนลด</th>
                        <th>จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="producrPO in producrPOs">
                        <td>{{$index + 1}}</td>
                        <td>{{producrPO.pname}}</td>
                        <td>{{producrPO.remain}}</td>
                        <td>{{producrPO.type}}</td>
                        <td>{{producrPO.pricePerType}}</td>
                        <td>{{producrPO.discount}}</td>
                        <td ng-init="sumallprice(producrPO.priceall)"> {{producrPO.priceall}}</td>
                        <td><button class="btn btn-danger" ng-click = "delProPrePO(producrPO.prePo_id)">ลบ&#160;<span class="icon ion-android-remove-circle font-weight-bold"></span> </button> </td>
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
                <p class="mb-0" >{{totalprice}}</p>
                <p class="mb-0">000000</p>
                <p class="mb-0">000000</p>
                <p class="mb-0">000000</p>
            </div>
        </div>



<!--..................................modal selectPro start........................................-->
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
                                    <span class="input-group-text font-weight-bold" id="inputGroup-sizing-sm" >จำนวน</span>
                                </div>
                                <input type="number" min="0" name="po_remain" id="po_remain" ng-model="po_remain" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm   col-sm-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm" >หน่วย</span>
                                </div>
                                <input type="text" name="po_type" id="po_type" ng-model="po_type" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="input-group input-group-sm   col-sm-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm" >ราคาต่อหน่วย</span>
                                </div>
                                <input type="text" name="po_pricePerType" id="po_pricePerType" ng-model="po_pricePerType" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm   col-sm-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  font-weight-bold" id="inputGroup-sizing-sm" >ส่วนลด</span>
                                </div>
                                <input type="text" name="po_discount" id="po_discount" ng-model="po_discount" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-success" ng-click="addToPrePO()" data-dismiss="modal">เพิ่ม</button>
            </div>

        </div>
    </div>
</div>

        <!--..................................modal selectPro start........................................-->
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
                                            <tbody>
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
        <!--......................................endmodal...................................-->


    </div>
</div>

<script>




    var app = angular.module("purchaseOrderApp", []);


    app.filter('startFrom', function() {
        return function(input, start) {
            if(input) {
                start = +start; //parse to int
                return input.slice(start);
            }
            return [];
        }
    });

    app.controller('purchaseOrdercontroller', function ($scope, $http, $timeout) {
        $scope.totalprice =0;
        $scope.po_discount = 0;
        $scope.countPro = 0;
        $scope.po_date = new Date();
        $scope.po_vat  = 7;
        $scope.po_disc =0;
        var sumpriceall = 0;
        var po_productid = null;
        $scope.sumallprice = function(allprice){
           sumpriceall = sumpriceall + parseFloat( allprice) ;
           $scope.totalprice = sumpriceall;

       };
        $http.get('php/pselect.php').then(function(res){
            $scope.list = res.data.records;
            $scope.currentPage = 1; //current page
            $scope.entryLimit = 5; //max no of items to display in a page
            $scope.filteredItems = $scope.list.length; //Initially for no filter
            $scope.totalItems = $scope.list.length;
        });
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
        $scope.selectProduct = function(id,name){

            $scope.po_pname = name ;
            po_productid = id;

        };
        $scope.addToPrePO = function(){

          $http.post('php/addToPrePO.php',{
              'po_productid': po_productid,
              'po_remain': $scope.po_remain,
              'po_type':$scope.po_type,
              'po_pricePerType':$scope.po_pricePerType,
              'po_discount' : $scope.po_discount
          }).then(function(res){
              po_productid = null;
              $scope.po_remain = null;
              $scope.po_type = null;
              $scope.po_pricePerType = null;
              $scope.po_discount = 0;
              sumpriceall = 0;

                $scope.selectPrePO();

          });
        };
        $scope.selectPrePO = function(){
          $http.get('php/selelctPrePO.php').then(function(res){
                    $scope.producrPOs  = res.data.records
          })
        };
        $scope.delProPrePO = function(id){

            swal({
                title: "คุณแน่ใจหรือไม่",
                text: "ยืนยันการลบข้อมูล",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((data) => {
                if (data) {

                    $http.post('php/delProPrePO.php',{
                        'id':id
                    }).then(function(){
                        swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                        sumpriceall = 0;
                        $scope.selectPrePO();
                    });

                }
            });

        };
        $scope.genPO_NO = function(){
            $http.get('php/genPO_NO.php').then(function(res){

                    $scope.po_no = res.data.records[0].rptPO_no;

            });
        };
        $scope.selectCompany = function () {
            $http.get("php/companySelect.php").then(function (response) {
                $scope.companys = response.data.records;
            });
        };
        $scope.setCompany = function (id, name) {
            $scope.cid = id;
            $scope.cname = name;


        };

    });


</script>
<script src="dist/sweetalert.min.js"></script>
<script type="application/javascript">
</script>
</body>
</html>