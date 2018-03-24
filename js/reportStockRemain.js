var app = angular.module("reportStockRemainApp", []);

app.controller("reportStockRemaincontroller", function ($scope, $http) {

 $scope.selectBranch = function(){

    $http.get('php/subbranchSelect.php').then( function(response){


        $scope.branchs = response.data.records;
      
    });
 }

    $scope.getAllStock = function(){
       
        $http.get('php/getReportStockRemain.php?branch='+$scope.branch).then( function(response){
    
    
            $scope.stocks = response.data.records;
            
        });

 }



});
