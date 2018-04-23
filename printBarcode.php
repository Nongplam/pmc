<?php
    if(isset($_GET['codenumber'])){
        $code = $_GET['codenumber'];
    }
?>


    <html>

    <head>
        <title>Barcodeprintting</title>
        <script src="js/lib/angular.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/lib/jquery-3.3.1.min.js"></script>
        <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/lib/JsBarcode.all.min.js"></script>
    </head>

    <body>
        <div ng-app="printBarcode" ng-controller="mainCtrl" class="ng-scope">
            <div class="container">
                <span>
            <!--<div class="row">
    <h5>Code is :</h5>    
        <h5><?php if(isset($_GET['codenumber'])){ echo $code; } ?></h5></div>-->
        <input class="input-group-lg" type="number" id="barcodeqty" ng-model="barcodeqty"/>
        <input type="hidden" id="barcodenum" value="<?php if(isset($_GET['codenumber'])){ echo $code; } ?>"/>
        </span>
                <button class="btn btn-primary" id="checkbtn">Print</button>
                <div class="container">
                    <!--<table class="table table-responsive">
                    <tbody>
                        <tr ng-repeat="i in getNumber(barcodeqty) track by $index">
                            <td><img class="barcodeimg" /></td>                            
                        </tr>
                    </tbody>
                </table>-->
                    <br>
                    <div class="row">
                        <div class="border border-dark" ng-repeat="i in getNumber(barcodeqty) track by $index">
                            <img class="barcodeimg" />
                        </div>
                        <!--Kai</p>-->
                    </div>
                    <div class="row">
                        <img id="barcodeimgja" />
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        var app = angular.module("printBarcode", []);
        app.controller("mainCtrl", function($scope, $http) {
            $scope.barcodeqty = 1;
            //$scope.number = 5;

            $scope.getNumber = function(num) {
                var temp = num / 4;
                //num = temp.toFixed();
                //console.log(num);
                return new Array(num);
            }
            
        });

    </script>
    <script>
        $(document).ready(function() {
            $("#barcodeqty").keyup(function() {
                JsBarcode(".barcodeimg", $("#barcodenum").val(), {
                    //lineColor: "#0aa",
                    width: 1,
                    height: 40,
                    displayValue: true,
                    fontSize: 16
                });
            });
            $("#barcodeqty").change(function() {
                JsBarcode(".barcodeimg", $("#barcodenum").val(), {
                    //lineColor: "#0aa",
                    width: 1,
                    height: 40,
                    displayValue: true,
                    fontSize: 16
                });
            });
            $(".barcodeimg").ready(function() {
                //$(".barcodeimg").JsBarcode($("#barcodenum").val());
                JsBarcode(".barcodeimg", $("#barcodenum").val(), {
                    //lineColor: "#0aa",
                    width: 1,
                    height: 40,
                    displayValue: true,
                    fontSize: 16
                });
            });
            $("#checkbtn").click(function() {
                window.print();
            });

        });

    </script>
    <script>


    </script>

    </html>
