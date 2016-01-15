app.directive('appInfo', function() {
  return {
    restrict: 'E', // Specifices How Directive will be used, 'E' = HTML element
    scope: {
      info: '=' // Specifies scope will pass information into directive through attr
                // named info. '=' means to look for attr named 'info' in the <app-info> element
                // that we created in this function.
    },
    templateUrl: 'js/directives/appInfo.html' // Tells code what HTML file is to be used to display
                                              // the content gained by $scope.info
  };
});
