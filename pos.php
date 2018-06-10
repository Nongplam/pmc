<!DOCTYPE html>
<html>
<?php
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_month_arr=array(
    "0"=>"",
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน", 
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"                 
);
function thai_date($time){
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return="วัน".$thai_day_arr[date("w",$time)];
    $thai_date_return.= "ที่ ".date("j",$time);
    $thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " พ.ศ.".(intval(date("Yํ",$time))+543);
    //$thai_date_return.= "  ".date("H:i",$time)." น.";
    return $thai_date_return;
}
    $eng_date=time();
?>

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
                    <span class="navbar-brand mb-0 h1"><?php echo $_SESSION["subbranchname"]; ?> <span><?php echo thai_date($eng_date); ?></span></span>
                    <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo " "; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                    <a href="logout.php"><button class="btn bg-light" type="button" id="logoutbtn">logout</button></a>
                </nav>
                <br>
                <div class="container-fluid row justify-content-between">
                    <div class="card col" ng-init="">
                        <div class="card-body">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle w-100" id="searchBtn" type="button" data-toggle="dropdown" ng-click="searchStock()">ค้นหาสินค้า<span class="caret"></span></button>
                                <ul class="dropdown-menu w-100" id="searchitemdropdown">
                                    <input class="form-control" id="myInput" ng-model="myInput" type="text" placeholder="Search.." ng-keyup="enterItembybarcode($event)" autofocus>
                                    <div ng-repeat="x in stocks | filter: myInput">
                                        <li class="dropdown-item" ng-click="setitemModal(x.lotno,x.pname,x.bname,x.stocktype,x.retailprice,x.sid,x.remain)"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#additemModal" data-stockid="{{x.sid}}" data-lotnumber="{{x.lotno}}" data-productname="{{x.pname}}" data-productbrand="{{x.bname}}" data-retailprice="{{x.retailprice}}" data-unit="{{x.stocktype}}" data-remain="{{x.remain}}" data-baseprice="{{x.baseprice}}">{{x.pname}} {{x.bname}} หน่วย: {{x.stocktype}} หมดอายุวันที่: {{datethaiformat(x.expireday)}}</button>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                            <br>
                            <h1>รายการ : {{newbill}}
                            </h1>

                            <table class="table col">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>ชื่อผลิตภัณฑ์</th>
                                        <th>ชื่อตัวยาหลัก</th>
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
                                        <td>{{y.price}}</td>
                                        <td>{{y.qty}}</td>
                                        <td>{{y.stocktype}}</td>
                                        <td class="totalonlist">{{y.price*y.qty}}</td>
                                        <td ng-init="calculateallPrice()"><button class="btn btn-danger" ng-click="deleteItem(y.id)">x</button></td>
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
                                        <button class="btn btn-primary col-sm" data-toggle="modal" data-target="#membermodal" id="openmemberbtn" type="button" style="height:45px;width:400px;" ng-show="addmemberbtnbool">เพิ่มสมาชิก +</button>
                                        <button class="btn btn-danger" type="button" style="height:45px;width:400px;" ng-show="!addmemberbtnbool" ng-click="cancelcurrentMember()">ยกเลิก</button>
                                        <button class="btn btn-danger" id="openreturnmodalbtn" type="button" style="height:45px;width:100px;" data-toggle="modal" data-target="#returnproductmodal">คืนสินค้า</button>
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
                                                <span class="total-price" id="totalbefore" ng-bind="firsttotalPrice.toFixed(2)">0.00</span>
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
                                                <span class='total-price' id="totalafterdiscount" ng-bind="totalpriceafterDiscount.toFixed(2)">0.00</span>
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
                                                <span class="total-price" id="totaltax" ng-bind="totalpriceafterttax.toFixed(2)">0.00</span>
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
                                                <span class="total-price" id="sumtotal" ng-bind="totalpriceafterDiscount.toFixed(2)">0.00</span>
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
                                <h5 class="modal-title" id="additemModalLabel">เพิ่มสินค้าในตะกร้า</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                            </div>
                            <div class="modal-body">
                                <form id="modalformadditem">
                                    <div class="container">
                                        <div class="row">
                                            <h5>เลขล็อตที่ :&nbsp;</h5>
                                            <h5 id="lotnumber" ng-bind="lotnoitemModal"></h5>
                                        </div>
                                        <div class="row">
                                            <h5>ชื่อ :&nbsp;</h5>
                                            <h5 id="productname" ng-bind="pnameitemModal"></h5>
                                            <!--<br>
                                        <h5>แบรนด์ :&nbsp;</h5>
                                        <h5 id="productbrand" ng-bind="bnameitemModal"></h5>-->
                                        </div>
                                    </div>
                                    <!--<label id="productname">ชื่อ : </label>-->
                                    <!--<label id="lotnumber">เลขล็อตที่ : </label>-->
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-2 col-form-label">จำนวน:</label>
                                        <div class="col-sm-5">
                                            <input type="number" step="1" class="form-control" min="1" id="item-qty" ng-model="qtyitemModal" ng-keyup="submittocartenter($event)" ng-change="minvalidateqtyitemModal()">
                                        </div>
                                        <label for="message-text" class="col-sm-1 col-form-label" id="item-unit" ng-bind="typeitemModal"></label>
                                    </div>


                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-2 col-form-label">ราคา:</label>
                                        <div class="col-sm-8">
                                            <input type="number" required min="0" step="5" class="form-control" id="item-price" ng-model="priceitemModal" disabled>
                                        </div>
                                        <label for="message-text" class="col-sm-1 col-form-label">บาท</label>
                                        <input type="hidden" id="base-price">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-success" ng-click="submititemtoCart()" id="submittocart" data-dismiss="modal">เพิ่มในตะกร้า</button>
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
                                <h5 class="modal-title" id="checkoutModalLabel">สรุปราคา</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                            </div>
                            <div class="modal-body">
                                <form id="modalform">
                                    <div class="container">
                                        <div class="row">
                                            <h5>ยอดที่ต้องชำระ :&nbsp;</h5>
                                            <h5 id="money-total" ng-bind="totalpriceafterDiscount.toFixed(2)"></h5>
                                        </div>
                                    </div>
                                    <!--<label id="productname">ชื่อ : </label>-->
                                    <!--<label id="lotnumber">เลขล็อตที่ : </label>-->
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-2 col-form-label">ใส่จำนวนเงินที่ได้รับ :</label>
                                        <div class="col-sm-5">
                                            <input type="number" id="recivmoney" class="form-control" min="{{totalpriceafterDiscount}}" ng-keyup="calculateChange($event)" ng-model="moneyReceived">
                                        </div>
                                        <label for="message-text" class="col-sm-1 col-form-label">บาท</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-2 col-form-label">เงินทอน :</label>
                                        <div class="col-sm-8">
                                            <span class="input-group-text" ng-bind="moneyChange" id="money-change">0</span>
                                        </div>
                                        <label for="message-text" class="col-sm-1 col-form-label">บาท</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="message-text" class="col-sm-4 col-form-label">ช่องทางการชำระ :</label>
                                        <div class="row">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" ng-model="paymethod" value="cash" checked>
                                                <label class="custom-control-label" for="customRadioInline1">เงินสด</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" ng-model="paymethod" value="promptpay">
                                                <label class="custom-control-label" for="customRadioInline2">พร้อมเพย์</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input" ng-model="paymethod" value="qrcode">
                                                <label class="custom-control-label" for="customRadioInline3">QR Code</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-success" ng-click="submitCheckout()" id="submitcheckout" data-dismiss="modal">ยืนยัน</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--......................................endmodal...................................-->
                <!--....................................membermodalstart.............................-->
                <div role="dialog" tabindex="-1" class="modal fade show" id="membermodal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" ng-init="">
                            <div class="modal-header">
                                <h4 class="modal-title">สมาชิก</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="width:300px;background-color:rgb(72,150,232);" ng-click="searchMember()">ค้นหาสมาชิก</button>
                                    <div role="menu" class="dropdown-menu">
                                        <input class="form-control" id="mymemberInput" ng-model="mymemberInput" type="text" placeholder="Search..">
                                        <div ng-repeat="x in members | filter: mymemberInput">
                                            <li class="dropdown-item"><button type="button" class="btn btn-light" ng-click="setcurrentMember(x.fname,x.lname,x.point,x.level,x.status,x.citizenid); memberstatusicon()" data-dismiss="modal">{{x.fname}} {{x.lname}}</button><span ng-show="false">{{x.phonenumber}}{{x.citizenid}}</span></li>
                                        </div>
                                    </div>
                                </div><button class="btn btn-primary" id="newmemberbtn" data-toggle="modal" data-target="#addnewmembermodal" type="button">สมัครสมาชิก</button></div>
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
                                        <div class="col"><input type="text" class="form-control" style="width:171px;" ng-model="newmemberfname" id="newmemberfname" /></div>
                                        <div class="col"><label class="col-form-label">สกุล :</label></div>
                                        <div class="col"><input type="text" class="form-control" style="width:180px;" ng-model="newmemberlname" id="newmemberlname" /></div>
                                    </div>
                                    <div class="form-row newmemberrowbuffer">
                                        <div class="col"><label class="col-form-label">เลขบัตรประชาชน :</label></div>
                                        <div class="col"><input type="text" class="form-control" style="width:325px;" ng-model="newmembercitizenid" id="newmembercitizenid" /></div>
                                    </div>
                                    <div class="form-row newmemberrowbuffer">
                                        <div class="col"><label class="col-form-label">เบอร์โทรศัพท์ :</label></div>
                                        <div class="col"><input type="text" class="form-control" style="width:345px;" ng-model="newmemberphone" id="newmemberphone" /></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col"><label class="col-form-label">เพศ :</label></div>
                                        <div class="col">
                                            <select class="form-control" style="width:130px;" ng-model="newmembergender" id="newmembergender">
                                    
                                        <option value="ชาย" selected>ชาย</option>
                                        <option value="หญิง">หญิง</option>
                                    
                                    </select>
                                        </div>
                                        <div class="col"><label class="col-form-label">วันเกิด :</label></div>
                                        <div class="col"><input type="date" class="form-control" ng-model="newmemberbirthday" id="newmemberbirthday" /></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-primary" type="button" ng-click="regisnewMember()" id="submitnewmember" data-dismiss="modal">สมัคร</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--......................................endmodal...................................-->
                <!--....................................returnsmodalstart.............................-->
                <div role="dialog" tabindex="-1" class="modal fade show" id="returnproductmodal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">คืนสินค้า</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center" ng-show="showreturnmgrkey">
                                <input class="input-group-text col-7" id="mgrkey" type="password" ng-model="mgrpass" ng-keyup="returnmgrkeyEnter($event)" placeholder="กรุณาใส่รหัสผ่าน" />
                                <button class="btn btn-primary col-2" type="button" ng-click="returnmgrkey(mgrpass)">ยืนยัน</button>
                            </div>
                            <div class="modal-body d-flex justify-content-center" ng-show="showreturnrefkey">
                                <input class="input-group-text col-7" type="text" id="refkey" ng-model="refkey" placeholder="กรุณารหัสอ้างอิง" ng-keyup="returnrefkeyEnter($event)" />
                                <button class="btn btn-success col-2" type="button" ng-click="returnrefkey(); getreturnsItem()">ยืนยัน</button>
                            </div>
                            <div class="modal-body d-flex justify-content-center" ng-show="showreturnitem">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ชื่อสินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคาต่อชิ้น</th>
                                            <th>ราคารวม</th>
                                            <th>คืนสินค้า</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in returnitems">
                                            <td>{{item.pname}}</td>
                                            <td>{{item.qty}}</td>
                                            <td>{{item.price}}</td>
                                            <td>{{item.qty*item.price}} บาท</td>
                                            <td><input type="checkbox" name="returnitem" value="{{item.ddid}}" />
                                                <!--<button class="btn btn-danger">ตกลง</button>--></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-body d-flex justify-content-end" ng-show="showreturnitem">
                                <button class="btn btn-success col-2" type="button" data-dismiss="modal" ng-click="returnsCheckout('returnitem'); resetreturnitem()">คืนสินค้า</button>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="button" data-dismiss="modal" ng-click="resetreturnitem()">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--......................................endmodal...................................-->

            </div>


            <script>
                var app = angular.module('posApp', []);
                app.controller('productsCtrl', function($scope, $http, $timeout, $window) {
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
                    $scope.newmemberbirthday = new Date();
                    $scope.moneyChange = 0;
                    $scope.firsttotalPrice = 0;
                    $scope.totalpriceafterDiscount = 0;
                    $scope.totalpriceafterttax = 0;
                    $scope.paymethod = "cash";
                    $scope.showreturnmgrkey = true;
                    $scope.showreturnrefkey = false;
                    $scope.showreturnitem = false;
                    $scope.mgrpass = '';

                    $scope.returnsCheckout = function(checkboxName) {
                        var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'),
                            values = [];
                        var str = '';
                        Array.prototype.forEach.call(checkboxes, function(el) {
                            //values.push(el.value);
                            str = str + el.value + ",";
                        });
                        //console.log(values)
                        if (str == '') {
                            swal("รายการคืนสินค้าว่างเปล่า!", "กรุณาเลือกสินค้าที่ต้องการคืน", "warning");
                        } else {
                            $http.post("php/returnsitemCheckout.php", {
                                'ddid': str
                            }).then(function(data) {
                                swal("การคืนสินค้าเสร็จสิ้น", "ข้อมูลการคืนสินค้าถูกบันทึก กรุณาเก็บใบเสร็จจากลูกค้า", "success");
                                window.open('newposbillout.php', '_blank');
                            });
                        }

                    }




                    $scope.setitemModal = function(lotno, pname, bname, type, price, sid, remain) {
                        $scope.lotnoitemModal = lotno;
                        $scope.pnameitemModal = pname;
                        $scope.bnameitemModal = bname;
                        $scope.typeitemModal = type;
                        $scope.qtyitemModal = 1;
                        $scope.priceitemModal = parseFloat(price);
                        $scope.siditemModal = sid;
                        $scope.remainitemModal = remain;
                    }

                    $scope.getreturnsItem = function() {
                        var refkey = $scope.refkey;
                        $http.get("php/getreturnitem.php?refkey=" + refkey).then(function(response) {
                            $scope.returnitems = response.data.records;
                        });
                    }

                    $scope.getnewbill = function() {
                        $http.get("php/getnextbillNo.php").then(function(response) {
                            $scope.newbill = response.data;
                        });
                    }

                    $scope.submititemtoCart = function() {
                        $scope.myInput = "";
                        $http.post("php/addtoCart.php", {
                            'stockid': $scope.siditemModal,
                            'price': $scope.priceitemModal,
                            'qty': $scope.qtyitemModal
                        }).then(function(data) {
                            $scope.posItem();
                        });
                    }

                    $scope.calculateallPrice = function() {
                        $scope.firsttotalPrice = 0;
                        for (var i = 0; i < $scope.positems.length; i++) {
                            $scope.firsttotalPrice = $scope.firsttotalPrice + ($scope.positems[i].price * $scope.positems[i].qty);
                        }
                        $scope.totalDiscount = 0;
                        $scope.totalpriceafterDiscount = $scope.firsttotalPrice - $scope.totalDiscount;
                        $scope.totalpriceafterttax = $scope.totalpriceafterDiscount * 0.07;
                        $scope.moneyReceived = $scope.totalpriceafterDiscount;
                    }

                    $scope.regisnewMember = function() {
                        if ($scope.newmemberfname.length < 1) {
                            sweetAlert("กรุณาใส่ชื่อสมาชิก", "", "warning");
                        } else if ($scope.newmemberlname.length < 1) {
                            sweetAlert("กรุณาใส่นามสกุลสมาชิก", "", "warning");
                        } else if ($scope.newmembercitizenid.length != 13) {
                            sweetAlert("กรุณาใส่เลขบัตรประชาชนให้ครบ", "", "warning");
                        } else if (isNaN($scope.newmembercitizenid)) {
                            sweetAlert("กรุณาใส่เลขบัตรประชาชนให้ถูกต้อง", "", "warning");
                        } else {
                            $http.post("php/insertnewmember.php", {
                                'fname': $scope.newmemberfname,
                                'lname': $scope.newmemberlname,
                                'citizenid': $scope.newmembercitizenid,
                                'phone': $scope.newmemberphone,
                                'gender': $scope.newmembergender,
                                'birthday': $scope.newmemberbirthday
                            }).then(function(data) {
                                //console.log(data.data);
                                if (data.data == "Member Inserted") {
                                    swal("สมัครสมาชิกเสร็จสิ้น", "สามารถใช้งานสมาชิกได้ทันที", "success");
                                    $scope.newmemberfname = "";
                                    $scope.newmemberlname = "";
                                    $scope.newmembercitizenid = "";
                                    $scope.newmemberphone = "";
                                    $scope.newmembergender = "";
                                    $scope.newmemberbirthday = "";
                                } else {
                                    swal("สมัครสมาชิกล้มเหลว!", "กรุณาตรวจสอบข้อมูลสมาชิก", "warning");
                                }
                                $scope.searchMember();
                            });
                        }
                    }

                    $scope.enterItembybarcode = function(e) {
                        if (e.keyCode == "13") {
                            ///1111111111123
                            //$scope.stocks["0"].barcode
                            //$scope.stocks["0"].barcode
                            var i = 0;
                            var barcode = $scope.myInput;
                            var isfound = false;
                            for (i = 0; i < $scope.stocks.length; i++) {
                                if ($scope.stocks[i].barcode == barcode) {
                                    isfound = true;
                                    $scope.setitemModal($scope.stocks[i].lotno, $scope.stocks[i].pname, $scope.stocks[i].bname, $scope.stocks[i].stocktype, $scope.stocks[i].retailprice, $scope.stocks[i].sid, $scope.stocks[i].remain);
                                }
                            }
                            if (!isfound) {
                                swal("รหัสสินค้าผิดพลาด!", "กรุณาสแกนบาร์โคดใหม่", "warning");
                            }
                        }
                    }

                    $scope.calculateChange = function(e) {
                        //console.log("keywork");
                        if ($scope.moneyReceived != undefined) {
                            //console.log($scope.moneyReceived);
                            $scope.moneyChange = $scope.moneyReceived - $scope.totalpriceafterDiscount;
                        } else {
                            $scope.moneyChange = 'จำนวนเงินไม่ถูกต้อง';
                        }
                        if (e.keyCode == 13) {
                            $scope.submitCheckout();
                        }
                    }


                    $scope.submitCheckout = function() {
                        if ($scope.moneyReceived == undefined) {
                            swal("คิดเงินล้มเหลว!", "กรุณาตรวจสอบจำนวนเงินที่ได้รับ", "warning");
                            $scope.moneyReceived = $scope.totalpriceafterDiscount;
                        } else {
                            $http.post("php/checkoutMaster.php", {
                                'sumprice': $scope.totalpriceafterDiscount,
                                'memberid': $scope.currentmemberid,
                                'changemoney': $scope.moneyChange,
                                'recivemoney': $scope.moneyReceived,
                                'paymethod': $scope.paymethod
                            }).then(function(data) {
                                $scope.moneyChange = 0;
                                $scope.firsttotalPrice = 0;
                                $scope.totalpriceafterDiscount = 0;
                                $scope.totalpriceafterttax = 0;
                                $scope.paymethod = "cash";
                                $scope.posItem();
                                window.open('newposbillout.php', '_blank');
                            });
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

                    $scope.datethaiformat = function(date) {
                        var d = new Date(date);
                        var year = d.getFullYear();
                        year = year + 543;
                        var month = d.getMonth();
                        var day = d.getDate();

                        return day + "/" + month + "/" + year;
                    }

                    $scope.searchProdect = function() {
                        $http.get("php/pselect.php").then(function(response) {
                            $scope.products = response.data.records;
                        });
                    }
                    $scope.posItem = function() {
                        $scope.getnewbill();
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
                                        $scope.posItem();
                                        $scope.calculateallPrice();
                                        //location.reload(true);
                                    });
                                }
                            });
                    }

                    //-------------------------------------Misc.------------------------------------------//

                    $scope.resetreturnitem = function() {
                        $scope.showreturnmgrkey = true;
                        $scope.showreturnrefkey = false;
                        $scope.showreturnitem = false;
                        $scope.mgrpass = '';
                        $scope.refkey = '';
                    }

                    $scope.returnmgrkey = function(mgrkey) {
                        if (mgrkey == '') {
                            swal("รหัสผ่านผิด!", "กรุณาติดต่อผู้จัดการสาขา", "warning");
                        } else {
                            $http.post("php/isMgr.php", {
                                'mgrkey': mgrkey
                            }).then(function(data) {
                                if (data.data == "Wrong") {
                                    swal("รหัสผ่านผิด!", "กรุณาติดต่อผู้จัดการสาขา", "warning");
                                } else {
                                    $scope.showreturnmgrkey = false;
                                    $scope.showreturnrefkey = true;
                                    $scope.showreturnitem = false;
                                    $scope.focusrefKey();
                                }
                            });
                        }
                    }

                    $scope.returnrefkey = function() {
                        $scope.getreturnsItem();

                        $scope.showreturnmgrkey = false;
                        $scope.showreturnrefkey = false;
                        $scope.showreturnitem = true;

                    }

                    $scope.focusrefKey = function() {
                        var refkey = $window.document.getElementById('refkey');
                        setTimeout(function() {
                            refkey.focus();
                        }, 200);
                    }

                    $scope.returnmgrkeyEnter = function(e) {
                        if (e.keyCode == '13') {
                            $scope.returnmgrkey($scope.mgrpass);
                        }
                    }

                    $scope.returnrefkeyEnter = function(e) {
                        if (e.keyCode == '13') {
                            $scope.returnrefkey();
                        }
                    }

                    $scope.memberstatusicon = function() {
                        if ($scope.currentstatus == 'active') {
                            $scope.currentstatusbool = true;

                        } else if ($scope.currentstatus == 'inactive') {
                            $scope.currentstatusbool = false;
                        }
                    }

                    $scope.minvalidateqtyitemModal = function() {
                        if ($scope.qtyitemModal < 1 || $scope.qtyitemModal == undefined) {
                            $scope.qtyitemModal = 1;
                        }
                    }

                    $scope.testpay = function() {
                        console.log($scope.paymethod);
                    }

                    $scope.submittocartenter = function(e) {
                        if (e.keyCode == "13") {
                            $scope.submititemtoCart();
                        }
                    }

                    $scope.logtest = function() {
                        console.log("this thing worked!");
                    }

                    //-------------------------------------Misc.------------------------------------------//
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
                    $("#searchBtn").click(function() {
                        setTimeout(function() {
                            $('#myInput').focus()
                        }, 200);
                    })

                    $("#myInput").keyup(function(key) {
                        var code = $("#myInput").val();
                        if (key.keyCode == 13 && code.length == 13) {
                            $("#additemModal").modal("show");
                        }
                    })

                    $("#item-qty").keyup(function(key) {
                        var code = $("#item-qty").val();
                        if (key.keyCode == 13) {
                            $("#additemModal").modal("hide");
                        }
                    })

                    $("#recivmoney").keyup(function(key) {
                        //var code = $("#item-qty").val();
                        if (key.keyCode == 13) {
                            $("#checkoutModal").modal("hide");
                        }
                    })

                    $('#additemModal').on('shown.bs.modal', function() {
                        $('#item-qty').trigger('select')
                    })
                    $('#checkoutModal').on('shown.bs.modal', function() {
                        $('#recivmoney').trigger('select')
                    })
                    $('#returnproductmodal').on('shown.bs.modal', function() {
                        $('#mgrkey').trigger('focus')
                    })
                })

            </script>
        </div>
    </body>
    <script src="dist/sweetalert.min.js"></script>




</html>
