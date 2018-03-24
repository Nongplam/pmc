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
        <h3 align="center">รายงานสินค้าในสต๊อคใกล้หมดอายุ และหมดอายุ แต่ละสาขา</h3>
        <div ng-app="reportStockExpireApp" ng-controller="reportStockExpirecontroller" class="ng-scope">
<form>

สาขา :
 <select  id="branch" name="branch" ng-model="branch" class="form-control custom-select" ng-init="selectBranch()" >
<option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
    
</select>
<!--<input type="radio" name="rChk" ng-model = "rChk" value = "1"> ทั้งหมด -->
<input type="radio" name="rChk"  ng-model = "rChk" value = "2" > ใกล้หมดอายุ
<input type="radio" name="rChk"  ng-model = "rChk" value = "3"> หมดอายุ
<input type="submit" name="" ng-click="getAllStock()" class="btn btn-success" value="ตกลง" style="width: 117px;">
</form>
     <table class="table table-info table-bordered" >
                <tbody>
                    <tr>
                        <th>เลขสต็อค</th>
                        <th>ผลิตภัณฑ์</th>
                        <th>เลขทะเบียนตํารับยา</th>
                        <th>แบรนด์</th>
                        
                        <th>จำนวน</th>
                        <th>หน่วย</th>
                        <th>ราคาทุน</th>
                        <th>เลขลอต</th>
                        <th>วันที่รับ</th>
                        <th>วันหมดอายุ</th>
                    </tr>
                    <tr  ng-repeat= "stock in stocks" >
                    <td>{{stock.sid}}</td>
                        <td>{{stock.pname}}</td>
                        <td>{{stock.productid}}</td>
                        <td>{{stock.bname}}</td>
                        
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




   <script src="js/reportStockExpire.js"></script>
    <script src="dist/sweetalert.min.js"></script>
</body>
 