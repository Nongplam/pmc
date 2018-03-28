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
    <div class="container" style="width:70%;">
        <div ng-app="extractstockApp" ng-controller="extractstockcontroller" class="ng-scope">
            <br>
            <h3 align="center">แยกหน่วย</h3>
            <hr>
            <div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>สินค้าเดิม</th>
                            <th>เลขลอต</th>
                            <th>หน่วย</th>
                            <th>ไป</th>                            
                            <th>หน่วย</th>
                            <th>จำนวน</th>
                        </tr>
                        <tr>
                            <td>product</td>
                            <td>lotno</td>
                            <td>type</td>
                            <td><i class="icon ion-android-arrow-forward d-flex justify-content-center text-danger" style="font-size:20px;"></i></td>
                            <td>newtype</td>
                            <td>newqty</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success">ยืนยัน</button>
                </div>
            </div>
            <hr>
            <h3 align="center">สต๊อก</h3>
            <hr>
            <label>ค้นหา :</label>
            <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="SearchInput" ng-keyup="customFilter(SearchInput)" placeholder="Search" />
            <br>
            <table class="table table-bordered" ng-init="displayData()">
                <tbody>
                    <tr>
                        <th>สินค้า</th>
                        <th>เลขที่ลอต</th>
                        <th>จำนวน</th>
                        
                        <th>หน่วย</th>
                        <th>วันหมดอายุ</th>
                        <th></th>                        
                    </tr>
                    <tr ng-repeat="stock in stocks | filter:SearchInput1 | filter:SearchInput2 | filter:SearchInput3">
                        <td>{{stock.pname}}</td> 
                        <td>{{stock.lotno}}</td>                       
                        <td>{{stock.remain}}</td>                        
                        <td>{{stock.stocktype}}</td>
                        <td>{{stock.expireday | date:'dd/MM/yyyy'}}</td>
                        <td><button class="btn btn-info" data-target="#extractmodal" data-toggle="modal">แยกหน่วย</button></td>
                    </tr>

                </tbody>
            </table>
            
            <!--...................................addusermodalstart...........................-->
            <div role="dialog" tabindex="-1" class="modal fade" id="extractmodal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#4395e1;">
                            <h4 class="modal-title" style="color:rgb(255,255,255);">แยกหน่วย</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                        <div class="modal-body" ng-init="getallSubbranch()">
                            <form id="formnewuser">
                                <div class="form-row newuserrowbuffer">
                                    <div class="col"><label class="col-form-label">ชื่อ :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newfname" style="width:171px;" id="newuserfname" />
                                    <br>
                                    </div>
                                    <div class="col"><label class="col-form-label">สกุล :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newlname" style="width:180px;" id="newuserlname" /></div>
                                </div>                                
                                <div class="form-row newuserrowbuffer">
                                    <div class="col"><label class="col-form-label">Username :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newusername" style="width:345px;" id="newuserusername" /></div>
                                </div>
                                <br>
                                <div class="form-row newuserrowbuffer">
                                    <div class="col"><label class="col-form-label">Password :</label></div>
                                    <div class="col"><input type="password" class="form-control" ng-model="newpassword" style="width:345px;" id="newuserpassword" /></div>
                                </div>                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="submit" id="submitnewuser" data-dismiss="modal" form="formnewuser" ng-click="submitnewUser()">เพิ่มผู้ใช้</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
            
        </div>
    </div>
    <script>
        var app = angular.module("extractstockApp", []);
        app.controller("extractstockcontroller", function($scope, $http) {
            
            $scope.displayData = function() {
                $http.get("php/stockSelect.php").then(function(response) {
                    $scope.stocks = response.data.records;
                });
            }
            $scope.inserttopreExtract =function(){
                $http.post("php/preextractInsert.php", {
                    'stockid': $scope.stockid,
                    'newtype': $scope.newtype,
                    'newqty': $scope.newqty
                })
                .then(function (data) {
                    sweetAlert("บันทึกข้อมูลเสร็จสิ้น", "ข้อมูลถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว", "success");
                    //$scope.displayData();
                });
            }
            $scope.customFilter = function(text){
                var res = text.split(" ");
                $scope.SearchInput1 = res[0];
                $scope.SearchInput2 = res[1];
                $scope.SearchInput3 = res[2];
            }
        });

    </script>
    <!--<script>
        $(document).ready(function(){
            $("button.btn.btn-info.addextractmodal").click(function(){
                console.log("work");
                $("#extractmodal").modal("show");
            });
        });    
    </script>-->
</body>
