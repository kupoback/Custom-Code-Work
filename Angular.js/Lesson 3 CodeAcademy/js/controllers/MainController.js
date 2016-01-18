// This either holds the information or gives the controller specific
// directions on how to handle the information given. This content
// is stored by the $scope handler.
app.controller('MainController', ['$scope', 'forecast', function($scope, forecast) {
	forecast.success(function(data) {
    $scope.fiveDay = data;
  });
}]);
