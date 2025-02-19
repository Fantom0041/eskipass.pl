/*!
 * remark v1.0.4 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(window, document, $, angular) {
  'use strict';

  var AngularApp = angular.module('AngularApp', ['ngSanitize', 'ui.router', "oc.lazyLoad"]);

  AngularApp.controller('AngularUIController', ['$scope', 'resoucre', function($scope, resoucre) {
    $scope.model = resoucre.data;
  }]);

})(window, document, jQuery, angular);
