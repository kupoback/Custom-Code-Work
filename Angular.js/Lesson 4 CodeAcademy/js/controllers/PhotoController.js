app.controller('PhotoController', ['$scope', 'photos', '$routeParams', function($scope, photos, $routeParams) {
  photos.success(function(data) {
    // $routeParams is AngularJS's. We are using it to retrieve the
    // variable id from the data.
    $scope.detail = data[$routeParams.id];
  });
}]);
