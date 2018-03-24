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
                        <input type="text" id="productName" name="productName" ng-model="productName" ng-init="selectProduct()" class="form-control dropdown-toggle w-100 ng-pristine ng-untouched ng-valid ng-empty">
                        <ul class="dropdown-menu w-100 dropdown1butt" id="dropdown1">
                            <div ng-repeat="product in products | filter:productName">
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

            <table class="table table-bordered" ng-init="displayData()" id="stockTable">
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
                        console.log(isopen);
                    } else {
                        $("#dropdown1").hide();
                        isopen = false;
                        console.log(isopen);
                    }


                });
            });
        });

    </script>






    <script src="js/stock.js"></script>
    <script src="dist/sweetalert.min.js"></script>

</body>
