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
        if (!in_array("3", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div class="container" style="width:70%">
        <br>
        <h3 align="center">เพิ่มข้อมูลบริษัท</h3>
        <div ng-app="companyApp" ng-controller="companycontroller" class="ng-scope">

            <input type="hidden" name="cid" ng-model="cid" class="form-control ng-pristine ng-untouched ng-valid ng-empty" disabled/>

            <label>ชื่อบริษัท :</label>
            <input type="text" name="cname" ng-model="cname" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
            <label>ข้อมูลติดต่อ :</label>
            <input type="text" name="ccon" ng-model="ccon" class="form-control ng-pristine ng-untouched ng-valid ng-empty">

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
                        <!--<th>เลขบริษัท</th>-->
                        <th>ชื่อบริษัท</th>
                        <th>ข้อมูลติดต่อ</th>
                        <th>แก้ไข</th>
                        <th>ลบข้อมูล</th>
                    </tr>
                    <tr ng-repeat="company in companys | filter:SearchInput">
                        <!--<td>{{company.cid}}</td>-->
                        <td>{{company.cname}}</td>
                        <td>{{company.ccon}}</td>



                        <td><button class="btn btn-info btn-xs" ng-click="updateData(company.cid,company.cname,company.ccon)">แก้ไข</button></td>
                        <td><button class="btn btn-danger btn-xs" ng-click="deleteData(company.cid)">ลบ</button></td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>



    <script src="js/company.js"></script>
    <script src="dist/sweetalert.min.js"></script>
</body>
