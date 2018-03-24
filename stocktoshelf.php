<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <script src="js/lib/popper.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">



</head>

<body>

    <div class="container">
        <!--style="width:70%;"-->

        <div ng-app="stockApp" ng-controller="stockcontroller" class="ng-scope">
            <br>
            <h3 align="center">จัดสินค้าเข้าชั้นวาง</h3>
            <br>
            <label>ค้นหา : </label>
            <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="SearchInput" placeholder="Search" />
            <br>
            <table class="table table-bordered" ng-init="displayStock()" id="stockTable">
                <tbody>
                    <tr>
                        <th>สินค้า</th>
                        <th>เลขทะเบียน</th>
                        <th>บริษัท</th>
                        <th>จำนวน</th>
                        <th>เลขที่ลอต</th>
                        <th>หน่วย</th>
                        <th>วันที่รับเข้า</th>
                        <th>วันหมดอายุ</th>
                        <th>นำเข้า</th>

                    </tr>
                    <tr ng-repeat="stock in stocks | filter:SearchInput">
                        <td>{{stock.pname}}</td>
                        <td>{{stock.productid}}</td>
                        <td>{{stock.cname}}</td>
                        <td>{{stock.remain}}</td>
                        <td>{{stock.lotno}}</td>
                        <td>{{stock.stocktype}}</td>
                        <td>{{stock.receiveday | date:'dd/MM/yyyy'}}</td>
                        <td>{{stock.expireday | date:'dd/MM/yyyy'}}</td>

                        <td><button class="btn btn-info btn-xs" type="button" ng-click="setpreshelfModal(stock.sid,stock.lotno,stock.pname,stock.stocktype)" data-toggle="modal" data-target="#prestockModal">เตรียม</button></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <h3 align="center">สินค้าที่จะนำเข้าชั้น</h3>
            <hr>
            <div class="row">
                <div class="col col-6">
                    <div class="table-responsive">
                        <table class="table" ng-init="preshelf()">
                            <thead>
                                <tr>
                                    <th>สินค้า</th>
                                    <th>เลขทะเบียน</th>
                                    <th>เลขล็อต</th>
                                    <th>จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="preshelf in preshelfs">
                                    <td>{{preshelf.pname}}</td>
                                    <td>{{preshelf.productid}}</td>
                                    <td>{{preshelf.lotno}}</td>
                                    <td>{{preshelf.qty}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col d-flex justify-content-center align-items-center col-1"><i class="icon ion-android-arrow-forward d-flex justify-content-center" style="font-size:76px;"></i></div>
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:113px;">ชั้นวางเลขที่</th>
                                    <th>รายละเอียด</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="preshelf in preshelfs">
                                    <td>{{preshelf.toshelfno}}</td>
                                    <td>{{preshelf.shelfinfo}}</td>
                                    <td class="text-danger" ng-click="deletepreShelf(preshelf.id)">ลบ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <h3 align="right"><button class="btn btn-lg btn-success" ng-click="addtoshelf()">ยืนยันสินค้า</button></h3>
            <hr>

            <!--..................................modal addtoPOS start........................................-->
            <div class="modal fade" id="prestockModal" tabindex="-1" role="dialog" aria-labelledby="prestockModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="prestockModalLabel">เพิ่มสินค้าขึ้นชั้นวาง</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                        </div>
                        <div class="modal-body">
                            <form id="modalform">
                                <div class="container">
                                    <div class="row">
                                        <h5>เลขล็อตที่ :&nbsp; {{lotonmodal}} </h5>
                                        <h5 id="lotnumber"></h5>
                                    </div>
                                    <div class="row">
                                        <h5>ชื่อ :&nbsp; {{pnameonmodal}}</h5>
                                        <h5 id="productname"></h5>
                                    </div>
                                </div>
                                <!--<label id="productname">ชื่อ : </label>-->
                                <!--<label id="lotnumber">เลขล็อตที่ : </label>-->
                                <div class="form-group row">
                                    <label for="message-text" class="col-sm-2 col-form-label">จำนวน:</label>
                                    <div class="col-sm-5">
                                        <input type="number" min="1" step="1" class="form-control" ng-model="preshelfqtyonmodal">
                                    </div>
                                    <label for="message-text" class="col-sm-1 col-form-label" ng-bind="typeonmodal"></label>
                                    <input type="hidden" id="stocknumber" ng-model="stocknumber">
                                    <input type="hidden" id="stockremain" ng-model="stockremain">
                                </div>


                                <div class="form-group row">
                                    <label for="message-text" class="col-sm-2 col-form-label">เลขชั้น:</label>
                                    <div class="dropdown col-sm-8">
                                        <input type="text" ng-model="toshelfnomodal" ng-init="displayshelfChoose()" data-toggle="dropdown" class="form-control dropdown-toggle w-100 ng-pristine ng-untouched ng-valid ng-empty">
                                        <ul class="dropdown-menu w-100">
                                            <div ng-repeat="shelfchoose in shelfchooses">
                                                <li class="dropdown-item" ng-click="setshelfno(shelfchoose.shelfid,shelfchoose.shelfno,shelfchoose.shelfinfo,shelfchoose.shelfcode)"><a>ชั้นเลขที่ {{shelfchoose.shelfno}} {{shelfchoose.shelfinfo}}</a></li>

                                            </div>
                                        </ul>
                                    </div>
                                    <input type="hidden" ng-model="toshelfidmodal">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-success" ng-click="addtoprepare()" data-dismiss="modal">เพิ่มรายการ</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
        </div>
    </div>
    <script>
        var app = angular.module("stockApp", []);

        app.controller("stockcontroller", function($scope, $http) {
            //ดึงข้อมูล stock มาแสดง
            $scope.preshelfqtyonmodal = 1;
            $scope.toshelfmodal;
            $scope.displayStock = function() {
                $http.get("php/stockSelect.php").then(function(response) {
                    $scope.stocks = response.data.records;
                });
            }
            $scope.displayshelfChoose = function() {
                $http.get("php/shelfChoose.php").then(function(response) {
                    $scope.shelfchooses = response.data.records;
                });
            }
            $scope.preshelf = function() {
                $http.get("php/preshelfSelect.php").then(function(response) {
                    $scope.preshelfs = response.data.records;
                });
            }
            $scope.setpreshelfModal = function(sid, lotno, pname, type) {
                $scope.sidonmodal = sid;
                $scope.lotonmodal = lotno;
                $scope.pnameonmodal = pname;
                $scope.typeonmodal = type;
            }
            $scope.setshelfno = function(shelfid, shelfno, shelfinfo, shelfcode) {
                $scope.toshelfnomodal = shelfno;
                $scope.toshelfidmodal = shelfid;
                $scope.toshelfinfomodal = shelfinfo;
                $scope.toshelfcodemodal = shelfcode;
            }
            $scope.addtoprepare = function() {
                var stockid = $scope.sidonmodal;
                var qty = $scope.preshelfqtyonmodal;
                var shelfno = $scope.toshelfnomodal;
                $http.post("php/addtopreShelf.php", {
                    'stockid': stockid,
                    'qty': qty,
                    'shelfno': shelfno
                }).then(function(data) {
                    swal("บันทึกข้อมูลเสร็จสิ้น", "บันทึกข้อมูลแล้ว", "success");
                    $scope.sidonmodal = null;
                    $scope.preshelfqtyonmodal = 1;
                    $scope.toshelfnomodal = null;
                    $scope.preshelf();
                });

            }
            $scope.deletepreShelf = function(id) {
                var preshelfid = id;
                $http.post("php/deletepreShelf.php", {
                    'preshelfid': preshelfid
                }).then(function(data) {
                    swal("ลบข้อมูลเสร็จสิ้น", "ลบข้อมูลแล้ว", "success");
                    $scope.preshelf();
                });
            }
            $scope.addtoshelf = function() {
                var word = "Go";
                $http.post("php/addtoShelf.php", {
                    'word': word
                }).then(function(data) {
                    swal("บันทึกข้อมูลเสร็จสิ้น", "บันทึกข้อมูลแล้ว", "success");
                    $scope.preshelf();
                });
            }

            $scope.logtest = function() {
                alert("Work!!");
            }
        });

    </script>
    <script>


    </script>
    <script src="dist/sweetalert.min.js"></script>

</body>
