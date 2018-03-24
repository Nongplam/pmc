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
        <h3 align="center">รายงานสินค้าทำกำไร แต่ละสาขา</h3>
        <div ng-app="reportStockProfitApp" ng-controller="reportStockProfitcontroller" class="ng-scope">
<form>

สาขา :
 <select  id="branch" name="branch" ng-model="branch" class="form-control custom-select" ng-init="selectBranch()" >
<option ng-repeat="branch in branchs" value="{{branch.id}}">{{branch.name}}</option>
    
</select>
<input type="date" name="date1" ng-model = "date1"><input type="date" name="date2" ng-model = "date2">
<input type="submit" name="" ng-click="getAllStock()" class="btn btn-success" value="ตกลง" style="width: 117px;">
</form>
     <table class="table table-info table-bordered" >
                <tbody>
                    <tr>
                        <th>เลขสต็อค</th>
                        <th>ผลิตภัณฑ์</th>
                        <th>เลขทะเบียนตํารับยา</th>
                        <th>แบรนด์</th>
                        <th>ขายไป(บาท)</th>
                        <th>ราคาทุน(บาท)</th>
                        <th>กำไร(บาท)</th>
                        <th>เลขลอต</th>
                        <th>วันที่รับ</th>
                        
                    </tr>
                    <tr  ng-repeat= "stock in stocks" >
                        <td>{{stock.sid}}</td>
                        <td>{{stock.pname}}</td>
                        <td>{{stock.productid}}</td>
                        <td>{{stock.bname}}</td>
                        <td>{{stock.sell}}</td>
                        <td>{{stock.cost}}</td>
                        <td>{{stock.profit}}</td>
                        
                        <td>{{stock.lotno}}</td>
                        <td>{{stock.receiveday}}</td>
                       



                       

                    </tr>

                </tbody>
            </table>


  </div>
    </div>




   <script src="js/reportStockProfit.js"></script>
    <script src="dist/sweetalert.min.js"></script>
</body>
 