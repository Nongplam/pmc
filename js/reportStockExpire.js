

var app = angular.module("reportStockExpireApp", []);

app.controller("reportStockExpirecontroller", function ($scope, $http) {

 $scope.selectBranch = function(){

    $http.get('php/subbranchSelect.php').then( function(response){


        $scope.branchs = response.data.records;
      
    });
 }

    $scope.getAllStock = function(){


        
 $http.get('php/getReportStockExpire.php?branch='+$scope.branch+'&type='+$scope.rChk).then( function(response){
    
    
    $scope.stocks = response.data.records;
    
});
        console.log($scope.branch);
       console.log($scope.rChk);
     }



});