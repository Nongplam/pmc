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
        if (!in_array("14", $allowrule)){
            header("Location: auth.php");
        }

     ?>
        <div class="container" style="width:80%">
            <h3 align="center">รายงานสินค้าในสต๊อค แต่ละสาขา</h3>
            <div ng-app="reportStockRemainApp" ng-controller="reportStockRemaincontroller" class="ng-scope">
                <form>

                    สาขา :
                    <select id="branch" name="branch" ng-model="branch" class="form-control custom-select col-sm-4" ng-init="selectBranch()">
<option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
    
</select>
                    <input type="button" name="" ng-click="getAllStock()" class="btn btn-success" value="ตกลง" style="width: 117px;">
                </form>
                <div class="d-flex justify-content-start">
                    <h4>*เรียงจากจำนวนที่เหลืออยู่จากน้อยไปมาก</h4>
                </div>
                <table class="table table-bordered">
                    <tbody>
                        <tr class="table-info">
                            <th>เลขสต็อค</th>
                            <th>ผลิตภัณฑ์</th>
                            <th>เลขทะเบียนตํารับยา</th>
                            <th>จำนวนที่รับเข้า</th>
                            <th>จำนวนคงเหลือ</th>
                            <th>หน่วย</th>
                            <th>ราคาทุน</th>
                            <th>เลขลอต</th>
                            <th>วันที่รับ</th>
                            <th>วันหมดอายุ</th>
                        </tr>
                        <tr ng-repeat="stock in stocks">
                            <td>{{stock.sid}}</td>
                            <td>{{stock.pname}}</td>
                            <td>{{transregno(stock.realregno)}}</td>
                            <td>{{stock.remainfull}}</td>
                            <td>{{stock.remain}}</td>
                            <td>{{stock.stocktype}}</td>
                            <td>{{stock.costprice}}</td>
                            <td>{{stock.lotno}}</td>
                            <td>{{stock.receiveday}}</td>
                            <td>{{stock.expireday}}</td>





                        </tr>

                    </tbody>
                </table>


            </div>
        </div>




        <script src="js/reportStockRemain.js"></script>
        <script src="dist/sweetalert.min.js"></script>
</body>
