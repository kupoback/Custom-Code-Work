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


app.directive('installApp', function() {
  return {
    restrict: 'E',
    scope: {},
    templateUrl: 'js/directives/installApp.html',

    link: function(scope, element, attrs) {
      scope.buttonText = "Install",
      scope.installed = false,

      scope.download = function() {
        element.toggleClass('btn-active')
        if(scope.installed) {
          scope.buttonText = "Install";
          scope.installed = false;
        } else {
          scope.buttonText = "Uninstall";
          scope.installed = true;
        }
      }
    }
  };
});
