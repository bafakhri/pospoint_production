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
  <main ng-app="app" ng-controller="controller" ng-init="fetchProducts(); fetchCategories(); fetchTables(); setCategory(); setPage();" class="d-flex bg-black text-light">
    <!-- left side -->
    <section class="d-flex flex-column col-2 align-items-center h-100vh w-75">
      <div class="mt-3 text-center">
        <div class="h3">{{ date | date: 'hh:mm a' }}</div>
        <div>{{ date | date: 'dd MMM yyyy' }}</div>
      </div>
      <!-- logo -->
      <h2 class="p-3 m-0"><i class="fa fas fa-utensils"></i></h2>
      <!-- categories -->
      <div class="d-flex flex-column justify-content-center align-content-center align-items-center gap w-100">
        <div class="d-flex flex-column justify-content-center gap w-100">
          <div 
          class="p-1 btn btn-outline-light w-100 rounded-pill" 
          ng-repeat="c in categories" 
          ng-click="setCategory(c.category_name)">
            {{c.category_name}}
          </div>
        </div>
        <div class="d-flex flex-column gap align-items-center mt-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="category_page">Page</span>
            </div>
            <input list="category-pages"
              ng-model="page"
              onfocus="this.value=''" 
              onchange="this.blur()"
              ng-change="setPage(page);"
              id="category-page" 
              name="category-page" 
              aria-describedby="category_page"
              class="form-control"/>
            <datalist id="category-pages" ng-repeat="p in counter">
                <option value="1">
                <option value="2">
                <option value="3">
                <option value="4">
                <option value="5">
            </datalist>
          </div>
          <div class="d-flex flex-row gap">
            <button class="btn btn-outline-light rounded-pill" ng-disabled="page <= 1" ng-click="pageDown()" ><i class="fas fa-arrow-down"></i></button>
            <button class="btn btn-outline-light rounded-pill" ng-disabled="page == total_category_page" ng-click="pageUp()"><i class="fas fa-arrow-up"></i></button>
          </div>
        </div>
      </div>
      <!-- admin and logout btn  -->
      <div class="d-flex row justify-content-between mt-auto mb-3">
        <div class="btn text-light rounded-pill h5"><i class="fas fa-user"></i> Admin</div>
        <div class="btn text-light rounded-pill h5"><i class="fas fa-power-off"></i> Logout</div>
      </div>
    </section>
    <!-- middle section -->
    <section class="col-7 p-0 bg-black d-flex flex-column">
      <!-- tables -->
      <div class="align-items-baseline d-flex flex-row p-3 gap">
        <div ng-repeat="t in tables">
          <div ng-class="{'bg-gradient-dark' : t.status === 'Enable'}" class="card text-dark text-center shadow-md" >
            <div class="card-body p-3" ng-class="{'text-light' : t.status === 'Enable'}" >
              <div class="card-title"><h4>{{t.name}}</h4></div>
              <div > {{t.capacity}} </div>
            </div>
          </div>
        </div>
      </div>
      <section class="d-flex flex-column bg-white h-100 rounded">
        <!-- pagination -->
        <section class="d-flex justify-content-center my-2">
          <nav aria-label="Page navigation mt-3">
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
        <h2 class="text-center text-black text-capitalize">{{category}}</h2>
        <!-- products -->
        <section class="align-items-baseline d-flex flex-row p-3 gap">
          <div class="col-3 p-0" ng-repeat="p in products">
            <div class="card text-white text-center bg-gradient-dark shadow-md ">
              <div class="card-body px-2 py-3">
                <div class="card-title font-weight-bold">
                  <h5>{{p.product_name}}</h5>
                </div>
                <h1 class="align-content-center align-items-center border border-gray d-flex justify-content-center m-auto rounded-pill square"><i class="fas fa-utensils"></i></h1>
                <div class="d-flex flex-row justify-content-between align-items-center mt-1">
                  <div class="font-weight-light">Price: € {{p.product_price}}</div>
                  <button class="btn btn-outline-light rounded-pill"><i class="fas fa-plus"></i></button>
                </div>
              </div>
            </div>
          </div>
        </section>
      </section>
      <!-- buttons  -->
      <section class="align-items-baseline d-flex flex-row p-3 gap mt-auto justify-content-center">
        <button class="btn btn-outline-light rounded-pill">Cash Drawer</button>
        <button class="btn btn-outline-light rounded-pill">Customers</button>
        <button class="btn btn-outline-light rounded-pill">Subtotal</button>
        <button class="btn btn-outline-light rounded-pill">Take out</button>
        <button class="btn btn-outline-light rounded-pill">PLU</button>
        <button class="btn btn-outline-light rounded-pill">More</button>
      </section>
    </section>
    <section class="col-3 w-100 h-auto pt-3 p-0">
      <!-- cart -->
      <div class="zigzag text-black rounded d-flex flex-column py-3 mx-3 gap" style="--g:5px;">
        <!-- title -->
        <div class="px-3 border-bottom">
          <h5 class="m-0">Table 1</h5>
          <p class="p-0 m-0">John Doe</p>
        </div>
        <!-- cart -->
        <div class="px-3 border-bottom h overflow-hidden">
          <div class="grid g-columns column justify-content-between text-black" ng-repeat="p in products">
            <div class="text-black">
              <div class="fs-s strong">{{p.product_name}}</div>
              <div class="fs-s">Price: <strong>€ {{p.product_price}}</strong></div>
            </div>
            <div class="text-right fs-s">1</div>
            <div class="text-left pl-3 fs-s">€ {{p.product_price * 1}}</div>
          </div>
        </div>
        <!-- subtotal -->
        <div class="px-3 border-bottom">
          <div class="grid g-columns column justify-content-between text-black" style="--c: 4fr 1fr;">
            <h6 class="font-weight-bold m-0">Subtotal:</h6>
            <div class="text-left pl-1">€ 22.0</div>
          </div>
          <div class="grid g-columns column justify-content-between text-black" style="--c: 4fr 1fr;">
            <h6 class="m-0">Tax:</h6>
            <div class="text-left pl-1">€ 2.0</div>
          </div>
        </div>
        <!-- total -->
        <div class="px-3 border-bottom">
          <div class="grid g-columns column justify-content-between text-black" style="--c: 4fr 1fr;">
            <h6 class="m-0">Total:</h6>
            <div class="text-left pl-1">€ 24.0</div>
          </div>
        </div>
        <!-- checkout -->
        <div class="px-3 d-flex flex-row gap justify-content-center">
          <button class="btn btn-dark rounded-pill">Checkout</button>
          <button class="btn btn-outline-secondary rounded-pill">Cancel</button>
        </div>
      </div>
      <div class="d-flex flex-row py-2 px-3 gap">
        <div class="btn btn-outline-light grow-3 rounded-pill">Different Pay</div>
        <div class="btn btn-outline-light px-3 rounded-pill">€</div>
      </div>
      <div class="grid column g-columns g-rows gap mx-4 align-items-center justify-content-center" style="--c: 40px 40px 40px 40px;">
        <div class="btn btn-outline-light rounded-pill">0</div>
        <div class="btn btn-outline-light rounded-pill">c</div>
        <div class="btn btn-outline-light rounded-pill">,</div>
        <div class="btn btn-outline-light rounded-pill">1</div>
        <div class="btn btn-outline-light rounded-pill">2</div>
        <div class="btn btn-outline-light rounded-pill">3</div>
        <div class="btn btn-outline-light rounded-pill">4</div>
        <div class="btn btn-outline-light rounded-pill">5</div>
        <div class="btn btn-outline-light rounded-pill">6</div>
        <div class="btn btn-outline-light rounded-pill">7</div>
        <div class="btn btn-outline-light rounded-pill">8</div>
        <div class="btn btn-outline-light rounded-pill">9</div>
      </div>
    </section> <!-- end cart -->
 
  </main>
  <script>
    var app = angular.module('app', []);
    app.controller('controller', function($scope, $http) {
      $scope.date = new Date();
      $scope.total_category_page = 1;
      $scope.counter = 1;
      $scope.products = [];
      $scope.categories = [];
      $scope.tables = [];
      $scope.url = "<?= $url; ?>";
      $scope.fetchProducts = function(category) {
        var c = category ? "&category=" + category : '';
        $http.get($scope.url + "/product_action.php?action=products" + c)
        .then(function(data) { 
            $scope.products = data.data.data;
          });
      }
      // fetch category by pagination 
      // set category to fetch product by category
      $scope.category = null;
      $scope.categoryPage = null;
      $scope.setCategory = function(category) {
        if(category) {
          $scope.category = category;
          $scope.fetchProducts(category);
        } else {
          $scope.category = "Menus"
        }
      }
      $scope.skip = 7;
      $scope.page = 1;
      $scope.fetchCategories = function(page) {
        $http.get(`${$scope.url}/category_action.php?action=categories&page=${page}&skip=${$scope.skip}`)
        .then(function(data) { 
          $scope.categories = data.data.data;
          $scope.total_category_page = data.data.total_page
          })
      }
      $scope.pageDown = function() {
        if($scope.page > 0){
          $scope.page = $scope.page - 1;
          $scope.fetchCategories($scope.page);
        }
        
      }
      $scope.pageUp = function() {
        if($scope.page > 0){
          $scope.page = $scope.page + 1;
          $scope.fetchCategories($scope.page);
        }
      }
      $scope.setPage = function(page) {
        $scope.page = page ? page : 1;
        $scope.fetchCategories($scope.page);
      }
      // fetch tables
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