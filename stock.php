<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <script src="js/lib/popper.min.js"></script>
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
        if (!in_array("8", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div class="container" style="width:70%;">

        <br>
        <h3 align="center">จัดการข้อมูลคลัง</h3>
        <div ng-app="stockApp" ng-controller="stockcontroller" class="ng-scope">
            <input type="hidden" name="sid" ng-model="sid">
            <label>สินค้า :</label>
            <input type="hidden" id="productid" name="productid" ng-model="productid">
            <div class="dropdown">
                <div class="row">
                    <div class="col col-10">
                        <input type="text" id="productName" name="productName" ng-model="productName" ng-init="selectProduct()" ng-keyup="customproductsearch(productName)" class="form-control dropdown-toggle w-100 ng-pristine ng-untouched ng-valid ng-empty">
                        <ul class="dropdown-menu w-100 dropdown1butt" id="dropdown1">
                            <div ng-repeat="product in products | filter:SearchInput1 | filter:SearchInput2 | filter:SearchInput3 | limitTo:20">
                                <li class="dropdown-item" ng-click="setProduct(product.regno,product.pname)"><a>{{product.pname}}</a></li>
                            </div>
                        </ul>

                    </div>
                    <div class="col">
                        <button class="btn btn-info col dropdown1butt" id="dropdown1btn">ค้นหา</button>

                    </div>

                </div>
            </div>

            <label>บริษัท : </label>
            <input type="hidden" id="cid" name="cid" ng-model="cid">
            <div class="dropdown">
                <input type="text" id="cname" name="cname" ng-model="cname" ng-init="selectCompany()" data-toggle="dropdown" class="form-control dropdown-toggle w-100 ng-pristine ng-untouched ng-valid ng-empty">
                <ul class="dropdown-menu w-100">
                    <div ng-repeat="company in companys | filter:cname">
                        <li class="dropdown-item" ng-click="setCompany(company.cid,company.cname)"><a>{{company.cname}}</a></li>

                    </div>
                </ul>
            </div>




            <label>จำนวน : </label>
            <input type="text" min="0" name="remain" ng-model="remain" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>เลขที่ลอต : </label>
            <input type="text" name="lotno" ng-model="lotno" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>หน่วย : </label>
            <div class="dropdown">
                <input type="text" name="stocktype" id="stocktype" ng-model="stocktypeval" ng-init="selectStocktype()" data-toggle="dropdown" class="form-control dropdown-toggle w-100 ng-pristine ng-untouched ng-valid ng-empty">
                <ul class="dropdown-menu w-100" id="stocktypeDropdown">
                    <div ng-repeat="stocktype in stocktypes | filter:stocktypeval">
                        <li class="dropdown-item" ng-click="setStocktype(stocktype.stocktype)"><a>{{stocktype.stocktype}}</a></li>

                    </div>
                </ul>
            </div>
            <label>ราคาต้นทุน : </label>
            <input type="text" min="0" name="costprice" ng-model="costprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ราคาฐาน : </label>
            <input type="text" min="0" name="baseprice" ng-model="baseprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ราคาบนกล่อง : </label>
            <input type="text" min="0" name="boxprice" ng-model="boxprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ราคาขายปลีก : </label>
            <input type="text" min="0" name="retailprice" ng-model="retailprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ราคาขายส่ง : </label>
            <input type="text" min="0" name="wholesaleprice" ng-model="wholesaleprice" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>วันที่รับเข้า : </label>
            <input type="date" name="receiveday" ng-model="receiveday" class="form-control">
            <label>วันหมดอายุ : </label>
            <input type="date" name="expireday" ng-model="expireday" class="form-control ng-pristine ng-untouched ng-valid ng-empty">

            <br>
            <br>
            <input type="submit" name="btnInsert" ng-click="insertData()" class="btn btn-success" value="{{btnName}}" style="width: 117px;">
            <input type="submit" name="btnCancel" ng-click="cancel()" class="btn btn-info" value="Cancel" style="width: 117px;">
            <br>
            <br>
            <label>ค้นหา</label>
            <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="SearchInput" placeholder="Search" />
            <br>
            <br>

            <table class="table table-bordered table-sm" ng-init="displayData()" id="stockTable">
                <tbody>
                    <tr>
                        <th>สินค้า</th>
                        <th>บริษัท</th>
                        <th>จำนวน</th>
                        <th>เลขที่ลอต</th>
                        <th>หน่วย</th>
                        <th>ราคาต้นทุน</th>
                        <th>ราคาฐาน</th>
                        <th>ราคาบนกล่อง</th>
                        <th>ราคาขายปลีก</th>
                        <th>ราคาขายส่ง</th>
                        <th>วันที่รับเข้า</th>
                        <th>วันหมดอายุ</th>
                        <th>แก้ไข</th>
                        <th>ลบข้อมูล</th>
                    </tr>
                    <tr ng-repeat="stock in stocks | filter:SearchInput">
                        <td>{{stock.pname}}</td>
                        <td>{{stock.cname}}</td>
                        <td>{{stock.remain}}</td>
                        <td>{{stock.lotno}}</td>
                        <td>{{stock.stocktype}}</td>
                        <td>{{stock.costprice}}</td>
                        <td>{{stock.baseprice}}</td>
                        <td>{{stock.boxprice}}</td>
                        <td>{{stock.retailprice}}</td>
                        <td>{{stock.wholesaleprice}}</td>
                        <td>{{stock.receiveday | date:'dd/MM/yyyy'}}</td>
                        <td>{{stock.expireday | date:'dd/MM/yyyy'}}</td>

                        <td><button class="btn btn-info btn-xs" ng-click="updateData(stock.sid,stock.productid,stock.pname,stock.cid,stock.cname,stock.remain,stock.lotno,stock.stocktype,stock.costprice,stock.baseprice,stock.boxprice,stock.retailprice,stock.wholesaleprice,stock.receiveday,stock.expireday)">แก้ไข</button></td>
                        <td><button class="btn btn-danger btn-xs" ng-click="deleteData(stock.sid)">ลบ</button></td>

                    </tr>

                </tbody>
            </table>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#dropdown1btn").ready(function() {
                var isopen = false;
                $(".dropdown1butt").click(function() {
                    if (!isopen) {
                        $("#dropdown1").show();
                        isopen = true;
                        //console.log(isopen);
                    } else {
                        $("#dropdown1").hide();
                        isopen = false;
                        //console.log(isopen);
                    }


                });
                $("#productName").focus(function() {
                    $("#dropdown1").show();
                    isopen = true;
                    //console.log(isopen);
                });
                $("#productName").blur(function() {
                    setTimeout(function() {
                        $("#dropdown1").hide();
                        isopen = false;
                        /*console.log(isopen);
                        console.log("blur worked");*/
                    }, 200);

                });

            });
        });

    </script>




    <script>
        var app = angular.module("stockApp", []);

        app.controller("stockcontroller", function($scope, $http) {
            $scope.btnName = "Insert";
            $scope.stocktype = "";
            $scope.receiveday = new Date();
            $scope.expireday = new Date();

            //เพิ่มข้อมูล
            $scope.insertData = function() {
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
                        .then(function(data) {

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
            $scope.displayData = function() {
                $http.get("php/stockSelect.php").then(function(response) {
                    $scope.stocks = response.data.records;
                });
            }

            $scope.customproductsearch = function(text) {
                var res = text.split(" ");
                $scope.SearchInput1 = res[0];
                $scope.SearchInput2 = res[1];
                $scope.SearchInput3 = res[2];
            }

            $scope.selectProduct = function() {
                $http.get("php/pselect.php").then(function(response) {
                    $scope.products = response.data.records;
                });
            }
            $scope.selectCompany = function() {
                $http.get("php/companySelect.php").then(function(response) {
                    $scope.companys = response.data.records;
                });
            }
            $scope.selectStocktype = function() {
                $http.get("php/stocktypeSelect.php").then(function(response) {
                    $scope.stocktypes = response.data.records;
                });
            }


            $scope.deleteData = function(sid) {

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
                            }).then(function(data) {
                                swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                                $scope.sid = null;
                                $scope.displayData();
                            });
                        }
                    });

            }
            //$scope.getBrandName = function (brandid) {};

            $scope.updateData = function(sid, productid, pname, cid, cname, remain, lotno, stocktype, costprice, baseprice, boxprice, retailprice, wholesaleprice, receiveday, expireday) {
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

            $scope.setStocktype = function(type) {
                //console.log("Work");
                $scope.stocktypeval = type;
            }


            $scope.setProduct = function(id, name) {
                //console.log("Work");
                $scope.productid = id;
                $scope.productName = name;
            }
            $scope.setCompany = function(id, name) {
                $scope.cid = id;
                $scope.cname = name;


            }

            $scope.logtest = function() {
                console.log($scope.stocktypeval);
            }

            $scope.cancel = function() {
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

    </script>


    <!--<script src="js/stock.js"></script>-->
    <script src="dist/sweetalert.min.js"></script>

</body>
