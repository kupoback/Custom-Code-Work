// This either holds the information or gives the controller specific
// directions on how to handle the information given. This content
// is stored by the $scope handler.
app.controller('HomeController', ['$scope', 'photos', function($scope, photos) {
  photos.success(function(data) {
    $scope.photos = data;
  });
}]);
