<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>



</head>

<body>
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
            <label>ค้นหา</label>
            <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="SearchInput" placeholder="Search" />
            <br>
            <br>
            <input type="submit" name="btnInsert" ng-click="insertData()" class="btn btn-success" value="{{btnName}}" style="width: 117px;">
            <input type="button" name="btnCancel" ng-click="cancel()" class="btn btn-info" value="Cancel" style="width: 117px;">
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
                    <tr ng-repeat="x in products | filter:SearchInput">
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

    <script src="js/product.js"></script>
    <script src="dist/sweetalert.min.js"></script>




</body>
