<?php
session_start();
include '../rms.php';
$url = "http://". $_SERVER["HTTP_HOST"];
?>
<!DOCTYPE html>
<html lang="en">
<title>Pospoint</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
  <link rel="stylesheet" href="<?= $url ?>/css/sb-admin-2.min.css">
  <link rel="stylesheet" href="<?= $url ?>/posapp/reyu.css">
  <link rel="stylesheet" href="<?= $url ?>/vendor/fontawesome-free/css/all.min.css">
  <script src="<?= $url ?>/js/angular.min.js"></script>
</head>

<body>
  <main ng-app="app" ng-controller="controller" ng-init="fetchProducts(); fetchCategories(); fetchTables();" class="d-flex bg-dark text-light">
    <!-- left side -->
    <section class="d-flex flex-column col-2 align-items-center h-100vh w-75">
      <!-- logo -->
      <h2 class="p-3"><i class="fa fas fa-utensils"></i></h2>
      <!-- categories -->
      <div class="d-flex flex-column justify-content-center align-content-center align-items-center gap w-100">
        <div class="p-1 btn btn-outline-light w-100 rounded-pill" ng-repeat="c in categories">{{c.category_name}}</div>
      </div>
      <!-- admin and logout btn  -->
      <div class="d-flex row justify-content-between mt-auto mb-3">
        <div class="btn text-light rounded-pill h5"><i class="fas fa-user"></i> Admin</div>
        <div class="btn text-light rounded-pill h5"><i class="fas fa-power-off"></i> Logout</div>
      </div>
    </section>
    <!-- middle section -->
    <section class="col-7 p-0">
      <!-- tables -->
      <div class="align-items-baseline d-flex flex-row p-3 gap">
        <div ng-repeat="t in tables">
          <div ng-class="{'bg-gradient-primary' : t.status === 'Enable'}" class="card text-dark text-center shadow-md" >
            <div class="card-body" ng-class="{'text-light' : t.status === 'Enable'}" >
              <div class="card-title"><h4>{{t.name}}</h4></div>
              <div > {{t.capacity}} </div>
            </div>
          </div>
        </div>
      </div>
      <!-- pagination -->
      <section class="d-flex justify-content-center mb-2">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
      </section>
      <!-- category name -->
      <h2 class="text-center">Dinner</h2>
      <!-- products -->
      <section class="align-items-baseline d-flex flex-row p-3 gap">
        <div class="col-3 p-0" ng-repeat="p in products">
          <div class="card text-dark text-center bg-gray-100 shadow-md">
            <div class="card-body">
              <div class="card-title font-weight-bold">
                <h5>{{p.product_name}}</h5>
              </div>
              <h1 class="align-content-center align-items-center border border-gray d-flex justify-content-center m-auto rounded-pill square"><i class="fas fa-utensils"></i></h1>
              <div class="d-flex flex-row justify-content-between align-items-center mt-1">
                <div class="font-weight-light">Price: $ {{p.product_price}}</div>
                <button class="btn btn-outline-primary rounded-pill"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>
    <section class="col-3 w-100 h-auto pt-3 p-0">
      <div class="zigzag text-dark rounded d-flex flex-column p-3">
        <div class="p-3">
          <h5>Table 1</h5>
          <p class="p-0 m-0">John Doe</p>
        </div>
        <hr class="w-100 m-0">
        <div class="d-flex flex-row p-3 justify-content-between">
          <div>
            <h6>Eggs</h6>
            <h6>Price: <strong>$ 5.00</strong></h6>
          </div>
          <div>1</div>
          <div>$ 5.00</div>
        </div>
      </div>
    </section>
  </main>
  <script>
    var app = angular.module('app', []);
    app.controller('controller', function($scope, $http) {
      $scope.products = [];
      $scope.categories = [];
      $scope.tables = [];
      $scope.url = "<?= $url; ?>";
      $scope.fetchProducts = function() {
        $http.get($scope.url+"/product_action.php?action=products")
        .then( function(data) { 
          $scope.products = data.data.data;
          })
      }
      $scope.fetchCategories = function() {
        $http.get($scope.url+"/category_action.php?action=categories")
        .then( function(data) { 
          $scope.categories = data.data.data; 
          })
      }
      $scope.fetchTables = function() {
        $http.get($scope.url+"/table_action.php?action=tables")
        .then( function(data) { 
          $scope.tables = data.data.data; 
          })
      }
      $scope.fetchCart = function() {
        $http.get('fetch_cart.php').then(function(data) {
          $scope.carts = data;
        })
      };

      $scope.setTotals = function() {
        var total = 0;
        for (var count = 0; count < $scope.carts.length; count++) {
          var item = $scope.carts[count];
          total = total + (item.product_quantity * item.product_price);
        }
        return total;
      };

      $scope.addtoCart = function(product) {
        $http({
          method: "POST",
          url: "add_item.php",
          data: product
        }).then(function(data) {
          $scope.fetchCart();
        });
      };

      $scope.removeItem = function(id) {
        $http({
          method: "POST",
          url: "remove_item.php",
          data: id
        }).then(function(data) {
          $scope.fetchCart();
        });
      };

    });
  </script>
</body>
</html>