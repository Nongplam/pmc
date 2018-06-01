<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
    <title>Newpage for Test sublime</title>
    <script type="text/javascript" src="./js/lib/angular.min.js"></script>
</head>

<body>
    <div ng-app="apTest" ng-controller="apt1Controller" class="ng-scope">
        <h2 ng-bind="val1"></h2>
        <h1>{{val1}}</h1>
    </div>
    <script type="text/javascript">
    var app = angular.module('apTest', [])
    app.controller('apt1Controller', ['$scope', function($scope, $http) {
        $scope.val1 = 'kindatest'
    }])
    </script>
</body>

</html>