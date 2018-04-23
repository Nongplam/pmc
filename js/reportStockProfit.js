var app = angular.module("reportStockProfitApp", []);

app.controller("reportStockProfitcontroller", function ($scope, $http) {
 $scope.date1 = new Date();
 $scope.date2 = new Date();
 $scope.selectBranch = function(){

    $http.get('php/subbranchSelect.php').then( function(response){


        $scope.branchs = response.data.records;
    });
 
 }

    $scope.getAllStock = function(){        
        $scope.date1.setHours(00);
        $scope.date1.setMinutes(00);
        $scope.date2.setHours(23);        
        $scope.date2.setMinutes(59);        
        $http.post("php/getReportStockProfit.php", {
            'branch': $scope.branch,
            'date1': $scope.date1,
            'date2': $scope.date2
        })
        .then(function (response) {
            $scope.stocks = response.data.records;
        });

        
        

 }



});
