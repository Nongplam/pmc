<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>



</head>

<body>
    <?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("5", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div class="container" style="width:70%">
        <h3 align="center">เพิ่มข้อมูลยา</h3>
        <div ng-app="productApp" ng-controller="productcontroller" class="ng-scope">
            <input type="hidden" ng-model="regno" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>เลขทะเบียนตํารับยา : </label>
            <input type="text" name="realregno" ng-model="realregno" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ชื่อผลิตภัณฑ์ : <span class="text-danger">*</span></label>
            <input type="text" name="pname" ng-model="pname" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ชื่อตัวยาหลัก</label>
            <input type="text" name="pcore" ng-model="pcore" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>รายละเอียดของผลิตภัณฑ์</label>
            <input type="text" name="pdesc" ng-model="pdesc" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>แบรนด์สินค้า</label>

            <select id="brandid" name="brandid" ng-model="brandid" class="form-control custom-select" ng-init="selectBrand()">  
                    <option ng-repeat="brand in brands" value="{{brand.bid}}">{{brand.bname}}</option>
                      
            </select>
            <br>
            <br>
            <input type="submit" name="btnInsert" ng-click="insertData()" class="btn btn-success" value="{{btnName}}" style="width: 117px;">
            <input type="button" name="btnCancel" ng-click="cancel()" class="btn btn-info" value="Cancel" style="width: 117px;">
            <br>
            <br>
            <label>ค้นหา</label>
            <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="SearchInput" ng-keyup="customfiler(SearchInput)" placeholder="Search" />
            <br>
            <br>

            <table class="table table-bordered" ng-init="displayData()" id="stockTable">
                <tbody>
                    <tr>
                        <th>เลขทะเบียนตํารับยา</th>
                        <th>ชื่อผลิตภัณฑ์</th>
                        <th>ชื่อตัวยาหลัก</th>
                        <th>รายละเอียด</th>
                        <th>แบรนด์</th>
                        <th>แก้ไข</th>
                        <th>ลบข้อมูล</th>
                    </tr>
                    <tr ng-repeat="x in products | filter:SearchInput1 | filter:SearchInput2 | filter:SearchInput3 | limitTo:20">
                        <td id="realregno">{{x.realregno}}</td>
                        <td>{{x.pname}}</td>
                        <td>{{x.pcore}}</td>
                        <td>{{x.pdesc}}</td>
                        <td>{{x.brandName}}</td>

                        <td><button class="btn btn-info btn-xs" ng-click="updateData(x.regno,x.realregno,x.pname,x.pcore,x.pdesc,x.brandid)">แก้ไข</button></td>
                        <td><button class="btn btn-danger btn-xs" ng-click="deleteData(x.regno)">ลบ</button></td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <script>
        var app = angular.module("productApp", []);

        app.controller("productcontroller", function($scope, $http) {
            $scope.btnName = "Insert";
            //เพิ่มข้อมูล
            $scope.insertData = function() {


                if ($scope.pname == null) {
                    sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ชื่อผลิตภัณฑ์", "warning");
                    return false;
                } else {
                    $http.post("php/pinsert.php", {
                            'regno': $scope.regno,
                            'realregno': $scope.realregno,
                            'pname': $scope.pname,
                            'pcore': $scope.pcore,
                            'pdesc': $scope.pdesc,
                            'brandid': $scope.brandid,
                            'btnName': $scope.btnName
                        })
                        .then(function(data) {
                            $scope.regno = null;
                            $scope.realregno = null;
                            $scope.pname = null;
                            $scope.pcore = null;
                            $scope.pdesc = null;
                            $scope.brandid = null;
                            $scope.btnName = "Insert";
                            $scope.displayData();
                            sweetAlert("บันทึกข้อมูลเสร็จสิ้น", "ข้อมูลถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว", "success");
                        });
                }

            }
            //ดึงข้อมูล Product มาแสดง
            $scope.displayData = function() {
                $http.get("php/pselect.php").then(function(response) {
                    $scope.products = response.data.records;
                });
            }
            $scope.selectBrand = function() {
                $http.get("php/getBrandborn.php").then(function(response) {
                    $scope.brands = response.data.records;
                });
            }
            $scope.customfiler = function(text) {
                var res = text.split(" ");
                $scope.SearchInput1 = res[0];
                $scope.SearchInput2 = res[1];
                $scope.SearchInput3 = res[2];
            }

            $scope.deleteData = function(regno) {

                swal({
                        title: "คุณแน่ใจหรือไม่",
                        text: "ยืนยันการลบข้อมูล",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((data) => {
                        if (data) {
                            $http.post("php/pdelete.php", {
                                'regno': regno
                            }).then(function(data) {
                                swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                                $scope.regno = null;
                                $scope.displayData();
                            });
                        }
                    });

            }
            //$scope.getBrandName = function (brandid) {};

            $scope.updateData = function(regno, realregno, pname, pcore, pdesc, brandid) {
                $scope.realregno = realregno;
                $scope.regno = regno;
                $scope.pname = pname;
                $scope.pcore = pcore;
                $scope.pdesc = pdesc;
                $scope.brandid = brandid;
                $scope.btnName = "Update";
            }
            $scope.cancel = function() {
                $scope.realregno = null;
                $scope.regno = null;
                $scope.pname = null;
                $scope.pcore = null;
                $scope.pdesc = null;
                $scope.brandid = null;
                $scope.btnName = "Insert";
            }
        });

    </script>

    <!--<script src="js/product.js"></script>-->
    <script src="dist/sweetalert.min.js"></script>




</body>
