var app = angular.module("reportStockSubbranchApp", []);

app.controller("reportStockSubbranchcontroller", function ($scope, $http) {

    $scope.date1 = new Date();
    $scope.date2 = new Date();
 $scope.selectBranch = function(){

    $http.get('php/subbranchSelect.php').then( function(response){


        $scope.branchs = response.data.records;
      
    });
 }

    $scope.getAllStock = function(){



        
       
        $http.post("php/getReportStockSubbranch.php",{
            'branch' : $scope.branch ,
            'date1' : $scope.date1,
            'date2' : $scope.date2

        }).then( function(response){
    
    
            $scope.stocks = response.data.records;
            
        });

 }



});
