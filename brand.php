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
        if (!in_array("2", $allowrule)){
            header("Location: auth.php");
        }
     ?>

    <div class="container" style="width:70%">
        <h3 align="center">เพิ่มข้อมูลแบรนด์</h3>
        <div ng-app="brandApp" ng-controller="brandcontroller" class="ng-scope">

            <input type="hidden" name="bid" ng-model="bid" class="form-control ng-pristine ng-untouched ng-valid ng-empty" disabled/>

            <label>ชื่อแบรนด์ :</label>
            <input type="text" name="bname" ng-model="bname" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ข้อมูลติดต่อ :</label>
            <input type="text" name="bcon" ng-model="bcon" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>เบอร์โทร</label>
            <input type="text" name="btel" ng-model="btel" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
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
            <table class="table table-bordered" ng-init="displayData()">
                <tbody>
                    <tr>
                        <th>เลขแบรนด์</th>
                        <th>ชื่อแบรนด์ </th>
                        <th>ข้อมูลติดต่อ</th>
                        <th>เบอร์โทร</th>
                        <th>แก้ไข</th>
                        <th>ลบข้อมูล</th>
                    </tr>
                    <tr ng-repeat="brand in brands | filter:SearchInput">
                        <td>{{brand.bid}}</td>
                        <td>{{brand.bname}}</td>
                        <td>{{brand.bcon}}</td>
                        <td>{{brand.btel}}</td>


                        <td><button class="btn btn-info btn-xs" ng-click="updateData(brand.bid,brand.bname,brand.bcon,brand.btel)">แก้ไข</button></td>
                        <td><button class="btn btn-danger btn-xs" ng-click="deleteData(brand.bid)">ลบ</button></td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <script src="js/brand.js"></script>
    <script src="dist/sweetalert.min.js"></script>
</body>
