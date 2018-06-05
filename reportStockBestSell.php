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
        if (!in_array("10", $allowrule)){
            header("Location: auth.php");
        }
     ?>
    <div class="container" style="width:70%">
        <h3 align="center">รายงานสินค้าขายดี แต่ละสาขา</h3>
        <div ng-app="reportStockBestSellApp" ng-controller="reportStockBestSellcontroller" class="ng-scope">
            <form>

                สาขา :
                <select id="branch" name="branch" ng-model="branch" class="form-control custom-select col-sm-4" ng-init="selectBranch()">
<option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
    
</select>
                <input type="submit" name="" ng-click="getAllStock()" class="btn btn-success" value="ตกลง" style="width: 117px;">
            </form>
            <table class="table table-info table-bordered">
                <tbody>
                    <tr>
                        <th>เลขสต็อค</th>
                        <th>ผลิตภัณฑ์</th>
                        <th>เลขทะเบียนตํารับยา</th>
                        <th>แบรนด์</th>
                        <th>ขายไป</th>
                        <th>ทั้งหมด</th>
                        <th>หน่วย</th>
                        <th>วันที่รับ</th>

                    </tr>
                    <tr ng-repeat="stock in stocks">
                        <td>{{stock.sid}}</td>
                        <td>{{stock.pname}}</td>
                        <td>{{stock.productid}}</td>
                        <td>{{stock.bname}}</td>
                        <td>{{stock.qtyall}}</td>
                        <td>{{stock.remainall}}</td>
                        <td>{{stock.stocktype}}</td>
                        <td>{{stock.receiveday}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/reportStockBestSell.js"></script>
    <script src="dist/sweetalert.min.js"></script>
</body>
