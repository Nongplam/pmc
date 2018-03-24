var app = angular.module("brandApp", []);

app.controller("brandcontroller", function ($scope, $http) {
    $scope.btnName = "Insert";
    //เพิ่มข้อมูล
    $scope.insertData = function () {
        if ($scope.bname == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ชื่อแบรนด์", "warning");
            return false;
        }
        if ($scope.bcon == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ที่อยู่", "warning");
            return false;
        }
        if ($scope.btel == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่เบอร์โทร", "warning");
            return false;
        } else {

            $http.post("php/brandInsert.php", {
                    'bname': $scope.bname,
                    'bcon': $scope.bcon,
                    'btel': $scope.btel,
                    'bid': $scope.bid,
                    'btnName': $scope.btnName
                })
                .then(function (data) {
                    sweetAlert("บันทึกข้อมูลเสร็จสิ้น", "ข้อมูลถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว", "success");
                    $scope.bname = null;
                    $scope.bcon = null;
                    $scope.btel = null;

                    $scope.btnName = "Insert";
                    $scope.displayData();
                });
        }

    }
    //ดึงข้อมูล Product มาแสดง
    $scope.displayData = function () {
        $http.get("php/getBrandborn.php").then(function (response) {
            $scope.brands = response.data.records;
        });
    }




    $scope.deleteData = function (bid) {

        swal({
                title: "คุณแน่ใจหรือไม่",
                text: "ยืนยันการลบข้อมูล",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((data) => {
                if (data) {
                    $http.post("php/brandDelete.php", {
                        'bid': bid
                    }).then(function (data) {
                        swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                        $scope.bid = null;
                        $scope.displayData();
                    });
                }
            });
    }
    //$scope.getBrandName = function (brandid) {};

    $scope.updateData = function (bid, bname, bcon, btel) {
        $scope.bid = bid
        $scope.bname = bname;
        $scope.bcon = bcon;
        $scope.btel = btel;

        $scope.btnName = "Update";
    }

    $scope.cancel = function () {
        $scope.bname = null;
        $scope.bcon = null;
        $scope.btel = null;
        $scope.btnName = "Insert";

    }
});
