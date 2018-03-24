var app = angular.module("productApp", []);

app.controller("productcontroller", function ($scope, $http) {
    $scope.btnName = "Insert";
    //เพิ่มข้อมูล
    $scope.insertData = function () {
        if ($scope.realregno == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่เลขทะเบียนตํารับยา", "warning");
            return false;
        }
        if ($scope.pname == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ชื่อผลิตภัณฑ์", "warning");
            return false;
        }
        if ($scope.brandid == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ยี่ห้อผลิตภัณฑ์", "warning");
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
                .then(function (data) {
                    sweetAlert("บันทึกข้อมูลเสร็จสิ้น", "ข้อมูลถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว", "success");
                    $scope.regno = null;
                    $scope.realregno = null;
                    $scope.pname = null;
                    $scope.pcore = null;
                    $scope.pdesc = null;
                    $scope.brandid = null;
                    $scope.btnName = "Insert";
                    $scope.displayData();
                });
        }

    }
    //ดึงข้อมูล Product มาแสดง
    $scope.displayData = function () {
        $http.get("php/pselect.php").then(function (response) {
            $scope.products = response.data.records;
        });
    }

    $scope.selectBrand = function () {
        $http.get("php/getBrandborn.php").then(function (response) {
            $scope.brands = response.data.records;
        });
    }


    $scope.deleteData = function (regno) {

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
                    }).then(function (data) {
                        swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                        $scope.regno = null;
                        $scope.displayData();
                    });
                }
            });

    }
    //$scope.getBrandName = function (brandid) {};

    $scope.updateData = function (regno, realregno, pname, pcore, pdesc, brandid) {
        $scope.realregno = realregno;
        $scope.regno = regno;
        $scope.pname = pname;
        $scope.pcore = pcore;
        $scope.pdesc = pdesc;
        $scope.brandid = brandid;
        $scope.btnName = "Update";
    }
    $scope.cancel = function () {
        $scope.realregno = null;
        $scope.regno = null;
        $scope.pname = null;
        $scope.pcore = null;
        $scope.pdesc = null;
        $scope.brandid = null;
        $scope.btnName = "Insert";
    }
});
