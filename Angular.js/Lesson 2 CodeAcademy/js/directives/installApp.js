app.directive('installApp', function () {
  return {
    restrict: 'E',
    scope: {

    },
    templateUrl: 'js/directives/installApp.html',

    // This option creates an interactive directive that responds
    // to users actions. In this case, it allows the user to choose
    // to install the App. If which case, this function will check
    // the validity of the state of the application
    // The link function takes three inputs:
    //  $scope, element and attrs
    // scope refers to the directives scope
    // element refers to the directive's HTML element
    // attrs contains the elements attributes
    link: function(scope, element, attrs) {
    // Here, inside the function are two properties, buttonText and installed
    // There is also the download function

      scope.buttonText = "Install",
      scope.installed = false,
      // This function uses the scope.installed to determine whether the
      // scope.installed is true or false. If it meets any of the conditions
      // within the statement, then all the parameters are executed
      scope.download = function() {
        element.toggleClass('btn-active')
        if (scope.installed) {
            scope.buttonText = "Install";
            scope.installed = false;
        }
        else {
          scope.buttonText = "Uninstall";
          scope.installed = true;
        }
      }
    }

  };
});
