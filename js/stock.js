var app = angular.module("stockApp", []);

app.controller("stockcontroller", function ($scope, $http) {
    $scope.btnName = "Insert";
    $scope.stocktype = "";
    $scope.receiveday = new Date();

    //เพิ่มข้อมูล
    $scope.insertData = function () {
        if ($scope.productid == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาเลือกสินค้า", "warning");
            return false;
        }
        if ($scope.cid == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ชื่อผลิตภัณฑ์", "warning");
            return false;
        }
        if ($scope.remain == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่จำนวน", "warning");
            return false;
        }


        if ($scope.lotno == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่เลขที่ลอต", "warning");
            return false;
        }
        if ($scope.stocktypeval == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่หน่วย", "warning");
            return false;
        }
        if ($scope.costprice == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาต้นทุน", "warning");
            return false;
        }
        if ($scope.baseprice == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาฐาน", "warning");
            return false;
        }
        if ($scope.boxprice == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาบนกล่อง", "warning");
            return false;
        }
        if ($scope.retailprice == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาขายปลีก", "warning");
            return false;
        }
        if ($scope.wholesaleprice == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่ราคาขายส่ง", "warning");
            return false;
        }
        if ($scope.receiveday == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่วันที่รับเข้า", "warning");
            return false;
        }
        if ($scope.expireday == null) {
            sweetAlert("บันทึกข้อมูลผิดพลาด", "กรุณาใส่วันหมดอายุ", "warning");
            return false;
        } else {
            $http.post("php/stockInsert.php", {
                    'sid': $scope.sid,
                    'productid': $scope.productid,
                    'cid': $scope.cid,
                    'remain': $scope.remain,
                    'lotno': $scope.lotno,
                    'stocktype': $scope.stocktypeval,
                    'costprice': $scope.costprice,
                    'baseprice': $scope.baseprice,
                    'boxprice': $scope.boxprice,
                    'retailprice': $scope.retailprice,
                    'wholesaleprice': $scope.wholesaleprice,
                    'receiveday': $scope.receiveday,
                    'expireday': $scope.expireday,
                    'btnName': $scope.btnName
                })
                .then(function (data) {

                    sweetAlert("บันทึกข้อมูลเสร็จสิ้น", "ข้อมูลถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว", "success");
                    $scope.sid = null;
                    $scope.productid = null;
                    $scope.productName = "";
                    $scope.cid = null;
                    $scope.cname = "";
                    $scope.remain = null;
                    $scope.lotno = null;
                    $scope.stocktypeval = "";
                    $scope.costprice = null;
                    $scope.baseprice = null;
                    $scope.boxprice = null;
                    $scope.retailprice = null;
                    $scope.wholesaleprice = null;
                    $scope.receiveday = null;
                    $scope.expireday = null;
                    $scope.btnName = "Insert";
                    $scope.displayData();
                });
        }

    }
    //ดึงข้อมูล stock มาแสดง
    $scope.displayData = function () {
        $http.get("php/stockSelect.php").then(function (response) {
            $scope.stocks = response.data.records;
        });
    }

    $scope.selectProduct = function () {
        $http.get("php/pselect.php").then(function (response) {
            $scope.products = response.data.records;
        });
    }
    $scope.selectCompany = function () {
        $http.get("php/companySelect.php").then(function (response) {
            $scope.companys = response.data.records;
        });
    }
    $scope.selectStocktype = function () {
        $http.get("php/stocktypeSelect.php").then(function (response) {
            $scope.stocktypes = response.data.records;
        });
    }


    $scope.deleteData = function (sid) {

        swal({
                title: "คุณแน่ใจหรือไม่",
                text: "ยืนยันการลบข้อมูล",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((data) => {
                if (data) {
                    $http.post("php/stockDelete.php", {
                        'sid': sid
                    }).then(function (data) {
                        swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                        $scope.sid = null;
                        $scope.displayData();
                    });
                }
            });

    }
    //$scope.getBrandName = function (brandid) {};

    $scope.updateData = function (sid, productid, pname, cid, cname, remain, lotno, stocktype, costprice, baseprice, boxprice, retailprice, wholesaleprice, receiveday, expireday) {
        $scope.sid = sid;
        $scope.productid = productid;
        $scope.productName = pname;
        $scope.cid = cid;
        $scope.cname = cname;
        $scope.remain = remain;
        $scope.lotno = lotno;
        $scope.stocktypeval = stocktype;
        $scope.costprice = costprice;
        $scope.baseprice = baseprice;
        $scope.boxprice = boxprice;
        $scope.retailprice = retailprice;
        $scope.wholesaleprice = wholesaleprice;
        $scope.receiveday = new Date(receiveday);
        $scope.expireday = new Date(expireday);
        $scope.btnName = "Update";
    }

    $scope.setStocktype = function (type) {
        //console.log("Work");
        $scope.stocktypeval = type;
    }


    $scope.setProduct = function (id, name) {
        //console.log("Work");
        $scope.productid = id;
        $scope.productName = name;
    }
    $scope.setCompany = function (id, name) {
        $scope.cid = id;
        $scope.cname = name;


    }

    $scope.logtest = function () {
        console.log($scope.stocktypeval);
    }

    $scope.cancel = function () {
        $scope.sid = null;
        $scope.productid = null;
        $scope.productName = null;
        $scope.cid = null;
        $scope.cname = null;
        $scope.remain = null;
        $scope.lotno = null;
        $scope.stocktypeval = null;
        $scope.costprice = null;
        $scope.baseprice = null;
        $scope.boxprice = null;
        $scope.retailprice = null;
        $scope.wholesaleprice = null;
        $scope.receiveday = null;
        $scope.expireday = null;
        $scope.btnName = "Insert";
    }
});
