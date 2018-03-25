<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pos</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/popper.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>

    <style>
        /* Style the input field */

        #myInput {
            padding: 8px;
            margin-top: -6px;
            border: 0;
            border-radius: 0;
            background: #f1f1f1;
        }

        #searchBtn {
            text-align: left
        }

        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-width: 1px;
            border-style: solid;

        }

        #xbtn {
            height: 70%;
        }

        #totalcart {
            font-size: 200%;
        }

        .price-tag {
            text-align: right;
        }

        #membersection {
            margin: 0 auto;
        }

        #membermodal {
            width: auto;
            margin: auto;
        }

        .form-row.newmemberrowbuffer {
            margin-bottom: 15px;
        }

    </style>
</head>

<body>
    <?php 
    session_start();
    include 'php/connectDB.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("4", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div id="productsCtrl" ng-app="posApp" ng-controller="productsCtrl">
        <div class="container-fluid border border-dark rounded">
            <br>
            <nav class="navbar navbar-dark bg-primary rounded">
                <span class="navbar-brand mb-0 h1">{{getBranchnames(<?php echo $_SESSION["subbranchid"]; ?>)}}</span>
                <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo " "; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                <a href="logout.php"><button class="btn bg-light" type="button" id="logoutbtn">logout</button></a>
            </nav>
            <br>
            <div class="container-fluid row justify-content-between">
                <div class="card col" ng-init="searchStock()">
                    <div class="card-body">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle w-100" id="searchBtn" type="button" data-toggle="dropdown">ค้นหาสินค้า<span class="caret"></span></button>
                            <ul class="dropdown-menu w-100">
                                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                <div ng-repeat="x in stocks">
                                    <li class="dropdown-item"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#additemModal" data-stockid="{{x.sid}}" data-lotnumber="{{x.lotno}}" data-productname="{{x.pname}}" data-productbrand="{{x.bname}}" data-retailprice="{{x.retailprice}}" data-unit="{{x.stocktype}}" data-remain="{{x.remain}}" data-baseprice="{{x.baseprice}}">เลขล็อต: {{x.lotno}} {{x.pname}} {{x.bname}} หน่วย: {{x.type}} หมดอายุวันที่: {{datethaiformat(x.expireday)}}</button>
                                        <!--<a href="#">เลขล็อต: {{x.lotno}} {{getPnames(x.sid)}} {{getPbrands(x.sid)}} หน่วย: {{x.type}} หมดอายุวันที่: {{datethaiformat(x.expireday)}}</a>--></li>
                                </div>
                            </ul>
                        </div>
                        <br>
                        <h1>รายการ : SR</h1>

                        <table class="table col">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>ชื่อผลิตภัณฑ์</th>
                                    <th>ชื่อตัวยาหลัก</th>
                                    <th>แบรนด์</th>
                                    <th>ราคา</th>
                                    <th>จำนวน</th>
                                    <th>หน่วย</th>
                                    <th>รวม</th>
                                </tr>
                            </thead>
                            <tbody class="positembody" ng-init="posItem()">
                                <!--<tr ng-repeat="x in products">-->
                                <tr ng-repeat="y in positems">
                                    <td>{{$index+1}}</td>
                                    <td class="pname">{{y.pname}}</td>
                                    <td>{{y.pcore}}</td>
                                    <td>{{y.bname}}</td>
                                    <td>{{y.price}}</td>
                                    <td>{{y.qty}}</td>
                                    <td>{{y.stocktype}}</td>
                                    <td class="totalonlist">{{y.price*y.qty}}</td>
                                    <td><button class="btn btn-danger" ng-click="deleteItem(y.id)">x</button></td>
                                </tr>
                                <!--<tr class="table-info">
                                    <td>P1</td>
                                    <th>แพ็คเกจพอนแสตนคู่ผงเกลือแร่</th>
                                    <th></th>
                                    <th></th>
                                    <th id="neganum">-20</th>
                                    <th>2</th>
                                    <th></th>
                                    <th class="discountonlist">-40</th>
                                    <th></th>
                                </tr>-->
                                <!--<tr class="table-info">
                                    <td>P2</td>
                                    <th>แพ็คเกจพอนแสตนคู่ผงเกลือแร่</th>
                                    <th></th>
                                    <th></th>
                                    <th id="neganum">-10</th>
                                    <th>2</th>
                                    <th></th>
                                    <th class="discountonlist">-20</th>
                                    <th></th>
                                </tr>-->
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="card col-4">
                    <div class="row">
                        <div class="card-body d-flex justify-content-center">
                            <div class="container d-flex justify-content-center">
                                <div class="row">
                                    <button class="btn btn-primary" id="openmemberbtn" type="button" style="height:45px;width:400px;" ng-show="addmemberbtnbool">เพิ่มสมาชิก +</button>
                                    <button class="btn btn-danger" type="button" style="height:45px;width:400px;" ng-show="!addmemberbtnbool" ng-click="cancelcurrentMember()">ยกเลิก</button>
                                    <br><br>
                                    <div class="container border border-primary rounded" ng-show="currentmemberboxbool">
                                        <table class="table table-hover">
                                            <tr ng-show="false">
                                                <td>
                                                    <span id="curmemberid">{{currentmemberid}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5>ชื่อ-สกุล :&nbsp;{{currentfname}} {{currentlname}}</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 ng-show="currentstatusbool">สถานะ :&nbsp;<img src="img/icon/correct.png"></h5>
                                                    <h5 ng-show="!currentstatusbool">สถานะ :&nbsp;<img src="img/icon/cross.png"></h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5>ระดับ :&nbsp;{{currentlevel}}</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5>คะแนนสะสม :&nbsp;{{currentpoint}}</h5>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">

                                <tr>
                                    <td>
                                        <span class="row-title">ราคา</span>
                                    </td>
                                    <td>
                                        <div class="price-tag">
                                            <span class="currency-symbol">฿</span>
                                            <span class="total-price" id="totalbefore">0.00</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="row-title">ส่วนลด</span>
                                    </td>
                                    <td>
                                        <div class="price-tag">
                                            <span class="currency-symbol">฿</span>
                                            <span class="total-price" id="discounttotal">0.00</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="row-title">ราคา</span>
                                        <span class="description">(หลังหักส่วนลด)</span>
                                    </td>
                                    <td>
                                        <div class="price-tag">
                                            <span class="currency-symbol">฿</span>
                                            <span class='total-price' id="totalafterdiscount">0.00</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="row-title">ภาษี</span>
                                        <span class="description">7%</span>
                                    </td>
                                    <td>
                                        <div class="price-tag">
                                            <span class="currency-symbol">฿</span>
                                            <span class="total-price" id="totaltax">0.00</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="row-title">ยอดรวม</span>
                                    </td>
                                    <td>
                                        <div class="price-tag" id="totalcart">
                                            <span class="currency-symbol">฿</span>
                                            <span class="total-price" id="sumtotal">0.00</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <button class="btn btn-success btn-lg col" id="checkout" data-toggle="modal" data-target="#checkoutModal">คิดเงิน</button>
                            <!--<hr>
                        <div class="row justify-content-between">
                            <h6 class="col">ราคา</h6>
                            <h6 class="col-4">฿0.00</h6>
                        </div>
                        <hr>
                        <div class="row justify-content-between">
                            <h6 class="col">ส่วนลด</h6>
                            <h6 class="col-4">฿0.00</h6>
                        </div>
                        <hr>
                        <div class="row justify-content-between">
                            <h6 class="col">ราคาหลังหักส่วนลด</h6>
                            <h6 class="col-4">฿0.00</h6>
                        </div>
                        <hr>
                        <div class="row justify-content-between">
                            <h6 class="col">ภาษี 7%</h6>
                            <h6 class="col-4">฿0.00</h6>
                        </div>
                        <hr>-->
                        </div>
                    </div>
                </div>

            </div>
            <br>

            <!--..................................modal addtoPOS start........................................-->
            <div class="modal fade" id="additemModal" tabindex="-1" role="dialog" aria-labelledby="additemModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="additemModalLabel">Title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                        </div>
                        <div class="modal-body">
                            <form id="modalform">
                                <div class="container">
                                    <div class="row">
                                        <h5>เลขล็อตที่ :&nbsp;</h5>
                                        <h5 id="lotnumber"></h5>
                                    </div>
                                    <div class="row">
                                        <h5>ชื่อ :&nbsp;</h5>
                                        <h5 id="productname"></h5>
                                        <h5>&nbsp; แบรนด์ :&nbsp;</h5>
                                        <h5 id="productbrand"></h5>
                                    </div>
                                </div>
                                <!--<label id="productname">ชื่อ : </label>-->
                                <!--<label id="lotnumber">เลขล็อตที่ : </label>-->
                                <div class="form-group row">
                                    <label for="message-text" class="col-sm-2 col-form-label">จำนวน:</label>
                                    <div class="col-sm-5">
                                        <input type="number" step="1" class="form-control" id="item-qty" ng-model="itemqty">
                                    </div>
                                    <label for="message-text" class="col-sm-1 col-form-label" id="item-unit">แผง</label>
                                    <input type="hidden" id="stocknumber" ng-model="stocknumber">
                                    <input type="hidden" id="stockremain" ng-model="stockremain">
                                </div>


                                <div class="form-group row">
                                    <label for="message-text" class="col-sm-2 col-form-label">ราคา:</label>
                                    <div class="col-sm-8">
                                        <input type="number" required min="0" step="5" class="form-control" id="item-price" ng-model="itemprice">
                                    </div>
                                    <label for="message-text" class="col-sm-1 col-form-label">บาท</label>
                                    <input type="hidden" id="base-price">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-success" id="submittocart" data-dismiss="modal">เพิ่มในตะกร้า</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->

            <!--..................................modal Checkout start........................................-->
            <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="checkoutModalLabel">Title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                        </div>
                        <div class="modal-body">
                            <form id="modalform">
                                <div class="container">
                                    <div class="row">
                                        <h5>ยอดที่ต้องชำระ :&nbsp;</h5>
                                        <h5 id="money-total"></h5>
                                    </div>
                                </div>
                                <!--<label id="productname">ชื่อ : </label>-->
                                <!--<label id="lotnumber">เลขล็อตที่ : </label>-->
                                <div class="form-group row">
                                    <label for="message-text" class="col-sm-2 col-form-label">ใส่จำนวนเงินที่ได้รับ :</label>
                                    <div class="col-sm-5">
                                        <input type="number" step="20" class="form-control" id="money-received">
                                    </div>
                                    <label for="message-text" class="col-sm-1 col-form-label">บาท</label>
                                </div>
                                <div class="form-group row">
                                    <label for="message-text" class="col-sm-2 col-form-label">เงินทอน :</label>
                                    <div class="col-sm-8">
                                        <span class="input-group-text" id="money-change">0</span>
                                    </div>
                                    <label for="message-text" class="col-sm-1 col-form-label">บาท</label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-success" id="submitcheckout" data-dismiss="modal">ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
            <!--....................................membermodalstart.............................-->
            <div role="dialog" tabindex="-1" class="modal fade show" id="membermodal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" ng-init="searchMember()">
                        <div class="modal-header">
                            <h4 class="modal-title">สมาชิก</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="width:300px;background-color:rgb(72,150,232);">ค้นหาสมาชิก</button>
                                <div role="menu" class="dropdown-menu">
                                    <input class="form-control" id="mymemberInput" type="text" placeholder="Search..">
                                    <div ng-repeat="x in members">
                                        <li class="dropdown-item"><button type="button" class="btn btn-light" ng-click="setcurrentMember(x.fname,x.lname,x.point,x.level,x.status,x.citizenid); memberstatusicon()" data-dismiss="modal">{{x.fname}} {{x.lname}}</button><span ng-show="false">{{x.phonenumber}}{{x.citizenid}}</span></li>
                                    </div>
                                </div>
                            </div><button class="btn btn-primary" id="newmemberbtn" type="button">สมัครสมาชิก</button></div>
                        <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
            <!--...................................addmembermodalstart...........................-->
            <div role="dialog" tabindex="-1" class="modal fade" id="addnewmembermodal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#4395e1;">
                            <h4 class="modal-title" style="color:rgb(255,255,255);">สมัครสมาชิก</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                        <div class="modal-body">
                            <form id="formnewmember">
                                <div class="form-row newmemberrowbuffer">
                                    <div class="col"><label class="col-form-label">ชื่อ :</label></div>
                                    <div class="col"><input type="text" class="form-control" style="width:171px;" id="newmemberfname" /></div>
                                    <div class="col"><label class="col-form-label">สกุล :</label></div>
                                    <div class="col"><input type="text" class="form-control" style="width:180px;" id="newmemberlname" /></div>
                                </div>
                                <div class="form-row newmemberrowbuffer">
                                    <div class="col"><label class="col-form-label">เลขบัตรประชาชน :</label></div>
                                    <div class="col"><input type="text" class="form-control" style="width:325px;" id="newmembercitizenid" /></div>
                                </div>
                                <div class="form-row newmemberrowbuffer">
                                    <div class="col"><label class="col-form-label">เบอร์โทรศัพท์ :</label></div>
                                    <div class="col"><input type="text" class="form-control" style="width:345px;" id="newmemberphone" /></div>
                                </div>
                                <div class="form-row">
                                    <div class="col"><label class="col-form-label">เพศ :</label></div>
                                    <div class="col">
                                        <select class="form-control" style="width:130px;" id="newmembergender">
                                    
                                        <option value="ชาย" selected>ชาย</option>
                                        <option value="หญิง">หญิง</option>
                                    
                                    </select>
                                    </div>
                                    <div class="col"><label class="col-form-label">วันเกิด :</label></div>
                                    <div class="col"><input type="date" class="form-control" id="newmemberbirthday" /></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="submit" id="submitnewmember" form="formnewmember">สมัคร</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->

        </div>


        <script>
            var app = angular.module('posApp', []);
            app.controller('productsCtrl', function($scope, $http) {
                var timer;
                $scope.currentfname = '';
                $scope.currentlname = '';
                $scope.currentpoint = '';
                $scope.currentlevel = '';
                $scope.currentstatus = '';
                $scope.currentmemberid = '';
                $scope.currentstatusbool = true;
                $scope.currentmemberboxbool = false;
                $scope.addmemberbtnbool = true;

                $scope.memberstatusicon = function() {
                    if ($scope.currentstatus == 'active') {
                        $scope.currentstatusbool = true;

                    } else if ($scope.currentstatus == 'inactive') {
                        $scope.currentstatusbool = false;
                    }
                }
                $scope.setcurrentMember = function(fname, lname, point, level, status, memberid) {
                    $scope.currentfname = fname;
                    $scope.currentlname = lname;
                    $scope.currentpoint = point;
                    $scope.currentlevel = level;
                    $scope.currentstatus = status;
                    $scope.currentmemberid = memberid;
                    $scope.currentmemberboxbool = true;
                    $scope.addmemberbtnbool = false;
                }
                $scope.cancelcurrentMember = function() {
                    $scope.currentfname = '';
                    $scope.currentlname = '';
                    $scope.currentpoint = '';
                    $scope.currentlevel = '';
                    $scope.currentstatus = '';
                    $scope.currentmemberboxbool = false;
                    $scope.addmemberbtnbool = true;
                }
                $scope.getBranchnames = function(id) {
                    var a = "";
                    $.ajax({
                        async: false,
                        url: "php/getBranchname.php?id=" + id,
                        success: function(data) {
                            a = data;
                        }
                    });
                    return a;
                }
                $scope.searchStock = function() {
                    $http.get("php/getallStock.php").then(function(response) {
                        $scope.stocks = response.data.records;
                    });
                }
                $scope.searchMember = function() {
                    $http.get("php/getallMember.php").then(function(response) {
                        $scope.members = response.data.records;
                    });
                }

                $scope.calculatePay = function(index) {
                    var sum = 0;
                    for (var i = 0; i <= index; i++) {
                        sum += parseFloat($scope.orderedList[i].price * $scope.orderedList[i].qty);
                    }
                    $scope.pricetotal = sum;
                    console.log("gg" + $scope.pricetotal);
                    //return sum;
                };
                /*$scope.showIt = function() {
                    timer = $timeout(function() {
                        $scope.hovering = true;
                    }, 2500);
                };*/

                /*$scope.addtoCart = function() {


                    var stocknumber = $scope.stocknumber;
                    var price = $scope.itemprice;
                    var qty = parseInt($scope.itemqty);
                    var remain = parseInt($scope.stockremain);
                    console.log(stocknumber);
                    console.log(price);
                    console.log(qty);
                    console.log(remain);*/
                /*if (remain >= qty) {
                        $.ajax({
                            type: 'post',
                            url: "php/addtoCart.php",
                            dataType: "json",
                            data: {
                                stockid: stocknumber,
                                price: price,
                                qty: qty
                            },
                            success: function(data) {
                                console.log("success");
                            }
                        });

                        location.reload();
                    } else {
                        sweetAlert("สินค้าไม่พอสำหรับจำหน่าย", "", "warning");
                    }
                }*/

                $scope.datethaiformat = function(date) {
                    var year = "-";
                    for (i = 0; i < 4; i++) {
                        year = year.concat(date[i]);
                    }
                    var month = "";
                    for (i = 4; i < 7; i++) {
                        month = month.concat(date[i]);
                    }
                    var day = "";
                    for (i = 8; i < 10; i++) {
                        day = day.concat(date[i]);
                    }
                    var correctdate = "";
                    correctdate = correctdate.concat(day);
                    correctdate = correctdate.concat(month);
                    correctdate = correctdate.concat(year);
                    return correctdate;
                }

                $scope.searchProdect = function() {
                    $http.get("php/pselect.php").then(function(response) {
                        $scope.products = response.data.records;
                    });
                }
                $scope.posItem = function() {
                    $http.get("php/cartItem.php").then(function(response) {
                        $scope.positems = response.data.records;
                    });
                }
                $scope.getPnames = function(sid) {
                    var a = "gg";
                    $.ajax({
                        async: false,
                        url: "php/getPname.php?stockid=" + sid,
                        success: function(data) {
                            a = data;
                        }
                    });
                    return a;
                }
                $scope.stockUnit = function(sid) {
                    var a = "gg";
                    $.ajax({
                        async: false,
                        url: "php/getstockUnit.php?stockid=" + sid,
                        success: function(data) {
                            a = data;
                        }
                    });
                    return a;
                }
                $scope.getPcores = function(sid) {
                    var a = "gg";
                    $.ajax({
                        async: false,
                        url: "php/getPcore.php?stockid=" + sid,
                        success: function(data) {
                            a = data;
                        }
                    });
                    return a;
                }
                $scope.getPbrands = function(sid) {
                    var a = "gg";
                    $.ajax({
                        async: false,
                        url: "php/getPbrand.php?stockid=" + sid,
                        success: function(data) {
                            a = data;
                        }
                    });
                    return a;
                }

                $scope.deleteItem = function(id) {
                    $scope.id = id;
                    swal({
                            title: "คุณแน่ใจหรือไม่",
                            text: "ยืนยันการลบข้อมูล",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((data) => {
                            if (data) {
                                $http.post("php/deleteposItem.php", {
                                    'id': $scope.id
                                }).then(function(data) {
                                    $scope.id = null;
                                    //$scope.posItem();
                                    location.reload(true);
                                });
                            }
                        });
                }

                $scope.logtest = function() {
                    console.log("this thing worked!");
                }
            });
            app.directive("repeatEnd", function() {
                return {
                    restrict: "A",
                    link: function(scope, element, attrs) {
                        if (scope.$last) {
                            scope.$eval(attrs.repeatEnd);
                        }
                    }
                };
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#submittocart").click(function() {
                    var stocknumber = $("#stocknumber").val();
                    var price = $("#item-price").val();
                    var qty = parseInt($("#item-qty").val());
                    var remain = parseInt($("#stockremain").val());
                    var subbranchid = <?php echo $_SESSION["subbranchid"]; ?>;
                    var userid = <?php echo $_SESSION["id"]; ?>;
                    if (remain >= qty) {
                        $.ajax({
                            type: 'post',
                            url: "php/addtoCart.php",
                            dataType: "json",
                            data: {
                                stockid: stocknumber,
                                price: price,
                                qty: qty,
                                subbranchid: subbranchid,
                                userid: userid
                            },
                            success: function(data) {
                                console.log("success");
                            }
                        });

                        location.reload();
                    } else {
                        sweetAlert("สินค้าไม่พอสำหรับจำหน่าย", "", "warning");
                    }
                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#submitcheckout").click(function() {
                    var sumprice = parseFloat($("#sumtotal").text());
                    var memberid = $("#curmemberid").text();
                    var recivemoney = $("#money-received").val();
                    var changemoney = $("#money-change").text();
                    var subbranchid = <?php echo $_SESSION["subbranchid"]; ?>;
                    var userid = <?php echo $_SESSION["id"]; ?>;
                    if (recivemoney >= sumprice) {
                        $.ajax({
                            type: 'post',
                            url: "php/checkoutMaster.php",
                            dataType: "json",
                            data: {
                                sumprice: sumprice,
                                recivemoney: recivemoney,
                                changemoney: changemoney,
                                memberid: memberid,
                                subbranchid: subbranchid,
                                userid: userid
                            },
                            success: function(data) {
                                console.log("success");
                            }
                        });
                        window.open('posbillout.php', '_blank');
                        location.reload();
                    } else {
                        sweetAlert("ใส่ยอดเงินไม่ถูกต้อง", "", "warning");
                    }

                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#item-price").change(function() {
                    var base = parseFloat($("#base-price").val());
                    if (parseFloat(this.value) < base) {
                        sweetAlert("ราคานี้ต่ำกว่าราคาที่มาตรฐานกำหนด", "", "warning");
                        $("#item-price").val(base);
                    }
                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $(".pname").ready(setTimeout(function() {
                    var total = 0;
                    var totaltax = 0;
                    var sumtotal = 0;
                    $(".totalonlist").each(function() {
                        total = total + parseFloat($(this).text());
                    })
                    $("#totalbefore").text(total.toFixed(2));
                    //
                    $("#discounttotal").ready(function() {
                        total = total - parseFloat($("#discounttotal").text())
                        $("#sumtotal").text(Math.ceil(total).toFixed(2));
                        $("#totalafterdiscount").text(Math.ceil(total).toFixed(2));
                        totaltax = total * 0.07;
                        $("#totaltax").text(totaltax.toFixed(2));
                    })

                    //sumtotal = total + totaltax;

                }, 500));
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".dropdown-menu li ").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#mymemberInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".dropdown-menu li ").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

        </script>
        <script>
            //modalControl
            $(document).ready(function() {
                $('#additemModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var price = button.data('retailprice')
                    //var recipient = button.data('whatever') // Extract info from data-* attributes
                    //lotnumber = "เลขล็อตที่ : " + lotnumber;
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.                
                    var modal = $(this)
                    modal.find('.modal-title').html('<b>เพิ่มรายการขาย</b>')
                    modal.find('.modal-body #item-qty').val("1")
                    modal.find('.modal-body #stocknumber').val(button.data('stockid'))
                    modal.find('.modal-body #stockremain').val(button.data('remain'))
                    modal.find('.modal-body #item-price').val(price)
                    modal.find('.modal-body #base-price').val(button.data('baseprice'))
                    $("#lotnumber").text(button.data('lotnumber'))
                    $("#productname").text(button.data('productname'))
                    $("#productbrand").text(button.data('productbrand'))
                    $("#item-unit").text(button.data('unit'))
                    //$("#stocknumber").text(button.data('stockid'))
                });
            });

        </script>
        <script>
            //modalControl
            $(document).ready(function() {
                $('.checkoutModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal                    
                    //var recipient = button.data('whatever') // Extract info from data-* attributes
                    //lotnumber = "เลขล็อตที่ : " + lotnumber;
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.                
                    var modal = $(this)
                    modal.find('.modal-title').html('<b>สรุปรายการ</b>')
                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $(".pname").ready(function() {
                    var naga = 0;
                    var totaldiscount = 0;
                    $(".discountonlist").each(function() {
                        totaldiscount = totaldiscount + parseFloat($(this).text());
                    })
                    $("#discounttotal").text(Math.abs(totaldiscount).toFixed(2));
                })
            })

        </script>
        <script>
            //modalcheckoutControl
            $(document).ready(function() {
                $(".pname").ready(setTimeout(function() {
                    var sumtotal = parseFloat($("#sumtotal").text());
                    console.log(sumtotal);
                    $("#money-total").html(sumtotal);
                    $("#money-received").val(sumtotal);
                    $("#money-received").change(function() {
                        var recive = $("#money-received").val();
                        $("#money-change").text(recive - sumtotal)
                    });
                    $("#money-received").keyup(function() {
                        var recive = $("#money-received").val();
                        $("#money-change").text(recive - sumtotal)
                    });

                }, 1000));
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#openmemberbtn").click(function() {
                    $("#membermodal").modal("show");
                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#newmemberbtn").click(function() {
                    $("#addnewmembermodal").modal("show");
                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $("#submitnewmember").click(function() {
                    var fname = $("#newmemberfname").val();
                    var lname = $("#newmemberlname").val();
                    var citizenid = $("#newmembercitizenid").val();
                    var phone = $("#newmemberphone").val();
                    var gender = $("#newmembergender").val();
                    var birthday = $("#newmemberbirthday").val();
                    if (fname.length < 1) {
                        sweetAlert("กรุณาใส่ชื่อสมาชิก", "", "warning");
                    } else if (lname.length < 1) {
                        sweetAlert("กรุณาใส่นามสกุลสมาชิก", "", "warning");
                    } else if (citizenid.length != 13) {
                        sweetAlert("กรุณาใส่เลขบัตรประชาชนให้ครบ", "", "warning");
                    } else if (isNaN(citizenid)) {
                        sweetAlert("กรุณาใส่เลขบัตรประชาชนให้ถูกต้อง", "", "warning");
                    } else {
                        $.ajax({
                            type: 'post',
                            url: "php/insertnewmember.php",
                            dataType: "json",
                            data: {
                                fname: fname,
                                lname: lname,
                                citizenid: citizenid,
                                phone: phone,
                                gender: gender,
                                birthday: birthday
                            },
                            success: function(data) {
                                console.log("success");
                            }
                        });
                        location.reload();
                    }
                });
            });

        </script>



    </div>
</body>
<script src="dist/sweetalert.min.js"></script>




</html>
