'use strict'
var app = angular.module("app", []);
const hostname = window.location.hostname;

const protocol = window.location.protocol + "//";
const url = protocol + hostname;
app.controller("controller", function ($scope, $http) {
  $scope.operator = ["+", "-", "*", "/"];
  $scope.firstVal = "";
  $scope.secondVal = "";
  $scope.currentOperator = "";
  $scope.result = "";
  var flag = false;
  $scope.numberDisplay = function (num) {
    assignValue(num);
  };
  function assignValue(num) {
    if (flag) {
      $scope.secondVal += num;
    } else {
      $scope.firstVal += num;
    }
  }
  function activeFlag() {
    falg = true;
  }
  $scope.createSecondValue = function (operator) {
    activeFlag();
    $scope.currentOperator = operator;
  };
  $scope.doMath = function () {
    if ($scope.firstVal != "" && $scope.secondVal != "") {
      var mathFormat =
        $scope.firstVal + $scope.currentOperator + $scope.secondVal;
      $scope.result = eval(mathFormat);
    }
  };

  $scope.clear = function () {
    valueFlag = false;
    $scope.firstVal = "";
    $scope.secondVal = "";
    $scope.currentOperator = "";
    $scope.result = "";
  };
  $scope.cart = [];
  $scope.date = new Date();
  $scope.total_category_page = 1;
  $scope.counter = 1;
  $scope.products = [];
  $scope.categories = [];
  $scope.tables = [];
  $scope.table = '';
  $scope.tax = 2.0;
  $scope.url = url;
  
  $scope.fetchProducts = function (category) {
    var c = category ? "&category=" + category : "";
    $http
      .get($scope.url + "/product_action.php?action=products" + c)
      .then(function (data) {
        $scope.products = data.data.data;
      });
  };
  // fetch category by pagination
  // set category to fetch product by category
  $scope.category = null;

  $scope.categoryPage = null;
  $scope.setCategory = function (category) {
    if (category) {
      $scope.category = category;
      $scope.fetchProducts(category);
    } else {
      $scope.category = "Menus";
    }
  };
  $scope.skip = 7;
  $scope.page = 1;
  $scope.fetchCategories = function (page) {
    $http
      .get(`${$scope.url}/category_action.php?action=categories`)
      .then(function (data) {
        $scope.categories = data.data.data;
        $scope.total_category_page = data.data.total_page;
      });
  };
  $scope.pageDown = function () {
    if ($scope.page > 0) {
      $scope.page = $scope.page - 1;
      $scope.fetchCategories($scope.page);
    }
  };
  $scope.pageUp = function () {
    if ($scope.page > 0) {
      $scope.page = $scope.page + 1;
      $scope.fetchCategories($scope.page);
    }
  };
  $scope.setPage = function (page) {
    $scope.page = page ? page : 1;
    $scope.fetchCategories($scope.page);
  };
  // fetch tables
  $scope.fetchTables = function () {
    $http
      .get($scope.url + "/table_action.php?action=tables")
      .then(function (data) {
        $scope.tables = data.data.data;
      });
  };
  $scope.fetchCart = function () {
    $http.get(`${$scope.url}/posapp/fetch_cart.php`).then(function (data) {
      $scope.cart = data.data;
    });
  };
  $scope.setTable = function (table) {
    $scope.table = table;
  };
  $scope.setTotal = function () {
    var total = 0;
    for (var count = 0; count < $scope.cart.length; count++) {
      var item = $scope.cart[count];
      total = total + item.product_quantity * item.product_price;
    }
    return total;
  };

  $scope.addToCart = function (product) {
    $http({
      method: "POST",
      url: $scope.url + "/posapp/add_item.php",
      data: product,
    }).then(function (data) {
      $scope.fetchCart();
    });
  };

  $scope.removeItem = function (id) {
    $http({
      method: "POST",
      url: "remove_item.php",
      data: id,
    }).then(function (data) {
      $scope.fetchCart();
    });
  };
  $scope.range = function (n) {
    return new Array(n);
  };
  // end
});