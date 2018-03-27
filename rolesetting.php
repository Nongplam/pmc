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
        if (!in_array("17", $allowrule)){
         header("Location: auth.php");
        }
     ?>
    <div class="container" style="width:70%">
        <br>
        <h3 align="center">จัดการสิทธ์ของตำแหน่ง</h3>
        <div ng-app="shelfmgrApp" ng-controller="shelfmgrController" class="ng-scope">

            <label>ค้นหา</label>
            <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="SearchInput" placeholder="Search" />
            <br>
            <br>
            <table class="table table-bordered" ng-init="displayData()">
                <tbody>
                    <tr>
                        <!--<th>เลขบริษัท</th>-->
                        <th>เลขตำแหน่ง</th>
                        <th>ชื่อตำแหน่ง : Eng</th>
                        <th>ชื่อตำแหน่ง : Thai</th>
                        <th>แก้ไข</th>
                    </tr>
                    <tr ng-repeat="shelf in shelfs | filter:SearchInput">
                        <!--<td>{{company.cid}}</td>-->
                        <td>{{shelf.shelfno}}</td>
                        <td>{{shelf.shelfcode}}</td>
                        <td>{{shelf.shelfinfo}}</td>

                        <td><button class="btn btn-info btn-xs" ng-click="updateData(shelf.shelfno,shelf.shelfcode,shelf.shelfinfo)">แก้ไข</button></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>



    <script>
        var app = angular.module("shelfmgrApp", []);

        app.controller("shelfmgrController", function($scope, $http) {
            $scope.btnName = "Insert";
            //เพิ่มข้อมูล
            $scope.disablebtn = false;
            $scope.insertData = function() {
                if ($scope.shelfno == null || $scope.shelfno == "") {
                    sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่เลขชั้นวาง", "warning");
                    return false;
                } else if ($scope.shelfcode == null || $scope.shelfcode == "") {
                    sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่โคดชั้นวาง", "warning");
                    return false;
                } else if ($scope.shelfinfo == null || $scope.shelfinfo == "") {
                    sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ตำแหน่งชั้นวาง", "warning");
                    return false;
                } else {

                    $http.post("php/shelfInsert.php", {
                            'shelfno': $scope.shelfno,
                            'shelfcode': $scope.shelfcode,
                            'shelfinfo': $scope.shelfinfo,
                            'btnName': $scope.btnName
                        })
                        .then(function(data) {
                            sweetAlert("บันทึกข้อมูลเสร็จสิ้น", "ข้อมูลถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว", "success");
                            $scope.shelfno = null;
                            $scope.shelfcode = null;
                            $scope.shelfinfo = null;
                            $scope.disablebtn = false;
                            $scope.btnName = "Insert";
                            $scope.displayData();
                        });
                }

            }

            $scope.displayData = function() {
                $http.get("php/getallShelf.php").then(function(response) {
                    $scope.shelfs = response.data.records;
                });
            }
            $scope.updateData = function(shelfno, shelfcode, shelfinfo) {
                $scope.shelfno = shelfno;
                $scope.shelfcode = shelfcode;
                $scope.shelfinfo = shelfinfo;
                $scope.disablebtn = true;
                $scope.btnName = "Update";
            }

            $scope.cancel = function() {
                $scope.shelfno = null;
                $scope.shelfcode = null;
                $scope.shelfinfo = null;
                $scope.disablebtn = false;
                $scope.btnName = "Insert";

            }
        });

    </script>
    <script src="dist/sweetalert.min.js"></script>
</body>
