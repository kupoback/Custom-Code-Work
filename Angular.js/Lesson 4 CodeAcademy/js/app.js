// This tells the index.html or where you add ng-app the name
// of the Module it's to gather it's information from.
var app = angular.module('GalleryApp', ['ngRoute']);
app.config(function ($routeProvider) {
  $routeProvider // Defines application routes within Angular
  	.when('/', {
      // Maps to the named controller. Inside that controller
      // information is passed into the $scope.photos. home.html
      // is using a ng-repeat to loop through each item in the
      // photos array, and display each photo
    	controller: 'HomeController',
    	tempalteUrl: 'views/home.html'
  })
  .when('/photos/:id', {
     controller: 'PhotoController',
     templateUrl: 'views/photo.html'
   })
  .otherwise({
    // This does as it says. If a user goes to another page
    // other than '/' or home, they are redirected to the
    // homepage.
    redirectTo: '/'
  });
});
