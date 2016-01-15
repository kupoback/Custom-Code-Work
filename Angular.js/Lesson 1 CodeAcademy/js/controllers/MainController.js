app.controller('MainController', ['$scope', function($scope) {
  $scope.title = 'Top Books!';
  $scope.promo = '$5.99';
  $scope.products = [
    {
      name: 'The Book of Trees',
      price: 19,
      pubdate: new Date('2014', '03', '08'),
      cover: 'img/the-book-of-trees.jpg',
      likes: 0,
      dislikes: 0
    },
    {
      name: 'Program or be Programmed',
      price: 8,
      pubdate: new Date('2013', '08', '01'),
      cover: 'img/program-or-be-programmed.jpg',
      likes: 0,
      dislikes: 0
    },
    {
      name: 'Lord of the Rings',
      price: 15,
      pubdate: new Date('1960', '01', '01'),
      cover: 'http://bestfantasybooks.com/blog/wp-content/uploads/2013/02/lotr.png',
      likes: 0,
      dislikes: 0
    },
    {
      name: 'American Gods',
      price: 20,
      pubdate: new Date('2008', '05', '15'),
      cover:   'http://www.neilgaiman.com/works/images/AmericanGods_MassMarketPaperback_1185415388.jpg',
      likes: 0,
      dislikes: 0
    }
  ];
  $scope.plusOne = function(index) {
  		$scope.products[index].likes += 1;
		};
  $scope.minusOne = function(index) {
  		$scope.products[index].likes += 1;
		};
}]);
