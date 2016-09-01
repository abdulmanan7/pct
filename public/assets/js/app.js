var pctApp = angular.module('pct',['ngRoute','ngCookies'])  
.directive('loading', function () {
      return {
        restrict: 'E',
        replace:true,
        template: '<div class="loading"><img src="img/ajax-loader.gif" class="ajax-loader"/></div>',
        link: function (scope, element, attr) {
              scope.$watch('loading', function (val) {
                  if (val)
                      $(element).show();
                  else
                      $(element).hide();
              });
        }
      }
  });
pctApp.config(function($routeProvider){
  $routeProvider
  .when('/Book/:bookId', {
    templateUrl: 'book.html',
    controller: 'BookController',
    resolve: {
      // I will cause a 1 second delay
      delay: function($q, $timeout) {
        var delay = $q.defer();
        $timeout(delay.resolve, 1000);
        return delay.promise;
      }
    }
  })
  .when('/', {
    templateUrl: './amazone.html',
    controller: 'amazoneController'
  }).when('/amazone', {
    templateUrl: './amazone.html',
    controller: 'amazoneController'
  }).when('/comparission', {
    templateUrl: './comparission.html',
    controller: 'comparissionController'
  })
  .when('/walmart', {
    templateUrl: './walmart.html',
    controller: 'walmartController'
  });
});
//controlller for login view
pctApp.controller("walmartController",["$scope","$filter","$http","$location",function($scope,$filter,$http,$location){
  $scope.keyword = "iphone";

  var url = "../walmart.php";
  $scope.get_data = function(){
    $http.post(url,{
      query:$scope.keyword
    }
    )
    .success(function(res){
      $scope.rData = res.items;
             // $location.path('/booking');
            // $cookies.put("logged",res); 
          });
  }    
}]);
pctApp.controller("amazoneController",["$scope","$filter","$http","$location",function($scope,$filter,$http,$location){
  $rData = {};
  $scope.keyword = "iphone";
  $scope.searchIndex = "FashionWomen";
  $scope.responseGroup = "Large";
  var url = "../amazone.php";
  $scope.get_data = function(){
    $http.post(url,{
      query:$scope.keyword,
      searchIndex:$scope.searchIndex,
      responseGroup:$scope.responseGroup,
    }
    )
    .success(function(res){
      $scope.rData = res;
    });
  }  
}]);
pctApp.controller("comparissionController",["$scope","$filter","$http","$location",function($scope,$filter,$http,$location){
  $scope.amazone = {};
  $scope.walmart = {};
  $scope.keyword = "iphone";
  $scope.responseGroup="";
  $scope.searchIndex = "FashionWomen";
  $scope.responseGroup = "";
  var urlAmazone = "../amazone.php";
  var urlWalmart = "../walmart.php";
  $scope.get_data = function(){
    $http.post(urlAmazone,{
      query:$scope.keyword,
      searchIndex:$scope.searchIndex,
      responseGroup:$scope.responseGroup,
      responseGroup:$scope.responseGroup,
    }
    )
    .success(function(res){
      $scope.amazone = res;
    });
    $http.post(urlWalmart,{
      query:$scope.keyword,
    }
    )
    .success(function(res){
      $scope.walmart = res.items;
    });
  }  
}]);
pctApp.controller("mainController",["$scope","$filter","$http","$location",function($scope,$filter,$http,$location){
  $scope.keyword = "iphone 7";
  $scope.view = "amazone";
  var url = ($location.path()=="/amazone")?"../amazone.php":($location.path()=="/walmart")?"../walmart.php":"../";
  $scope.get_data = function(){
    $http.post(url,{
      query:$scope.keyword,
    }
    )
    .success(function(res){
      $scope.rData = res;
             // $location.path('/booking');
            // $cookies.put("logged",res); 
          });
  }    
}]);
// module.factory('api_call', function($http) {
//  return {
//   get: function() {
//              //return the promise directly.
//              return $http.post(url,{
//               query:$scope.keyword,
//             }
//             )
//              .success(function(res){
//               $scope.rData = res;
//             });
//            }
//          }
//        });