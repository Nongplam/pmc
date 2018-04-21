<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Barcode</title>
    <script src="js/lib/angular.min.js"></script>
    <script src="js/lib/popper.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/lib/JsBarcode.code128.min.js"></script>
</head>

<body>
    <div ng-app="barcodeGen" ng-controller="mainCtrl" class="ng-scope">
        <div>
            <img id="barcode" />
            
        </div>
        <button class="btn btn-primary" id="barcodegenbtn">Click for Test</button>
    </div>
</body>
<script>
    var app = angular.module("barcodeGen", []);
    app.controller("mainCtrl", function($scope, $http) {
        
        
    });

</script>
<script>
    $(document).ready(function(){
        $("#barcodegenbtn").ready(function(){
            $("#barcode").JsBarcode("2352632545246");
        });
    });
</script>

</html>
