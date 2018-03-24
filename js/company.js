var app = angular.module("companyApp", []);

app.controller("companycontroller", function ($scope, $http) {
    $scope.btnName = "Insert";
    //เพิ่มข้อมูล
    $scope.insertData = function () {
        if ($scope.cname == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ชื่อบริษัท", "warning");
            return false;
        }
        if ($scope.ccon == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ข้อมูลติดต่อ", "warning");
            return false;
        } else {

            $http.post("php/companyInsert.php", {
                    'cname': $scope.cname,
                    'ccon': $scope.ccon,
                    'cid': $scope.cid,
                    'btnName': $scope.btnName
                })
                .then(function (data) {
                    sweetAlert("บันทึกข้อมูลเสร็จสิ้น", "ข้อมูลถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว", "success");
                    $scope.cname = null;
                    $scope.ccon = null;


                    $scope.btnName = "Insert";
                    $scope.displayData();
                });
        }

    }
    //ดึงข้อมูล Product มาแสดง
    $scope.displayData = function () {
        $http.get("php/companySelect.php").then(function (response) {
            $scope.companys = response.data.records;
        });
    }




    $scope.deleteData = function (cid) {

        swal({
                title: "คุณแน่ใจหรือไม่",
                text: "ยืนยันการลบข้อมูล",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((data) => {
                if (data) {
                    $http.post("php/companyDelete.php", {
                        'cid': cid
                    }).then(function (data) {
                        swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                        $scope.bid = null;
                        $scope.displayData();
                    });
                }
            });
    }
    //$scope.getBrandName = function (brandid) {};

    $scope.updateData = function (cid, cname, ccon) {
        $scope.cid = cid;
        $scope.cname = cname;
        $scope.ccon = ccon;
        $scope.btnName = "Update";
    }

    $scope.cancel = function () {
        $scope.cname = null;
        $scope.ccon = null;
        $scope.btnName = "Insert";

    }
});
