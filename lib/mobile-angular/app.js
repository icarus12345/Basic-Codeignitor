/* eslint no-alert: 0 */

'use strict';
var BASE_URL = '//localhost/CodeIgniter-3.1.4/'
var APP_ID = '12345';
var APP_SECRET = '6789';
//
// Here is how to define your module
// has dependent on mobile-angular-ui
//
var app = angular
    .module('MobileAngularUiExamples', [
        'ngRoute',
        'mobile-angular-ui',
        'loader',
        'vesparny.fancyModal',
        // touch/drag feature: this is from 'mobile-angular-ui.gestures.js'.
        // This is intended to provide a flexible, integrated and and
        // easy to use alternative to other 3rd party libs like hammer.js, with the
        // final pourpose to integrate gestures into default ui interactions like
        // opening sidebars, turning switches on/off ..
        'mobile-angular-ui.gestures'
    ])

    .run(function($transform) {
        window.$transform = $transform;
    })

//
// You can configure ngRoute as always, but to take advantage of SharedState location
// feature (i.e. close sidebar on backbutton) you should setup 'reloadOnSearch: false'
// in order to avoid unwanted routing.
//
    .config(function($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: 'template/home.html',
            reloadOnSearch: false,
            controller: 'MainController'
        });
        $routeProvider.when('/touch', {
            templateUrl: 'template/touch.html',
            reloadOnSearch: false,
            controller: 'TouchController'
        });
    })

    .factory('Auth',AuthFactory)
    .factory('API',APIFactory)

    .directive('passwordVerify', function() {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, elem, attrs, ngModel,$rootScope) {
                scope.$watch(attrs.ngModel, function() {
                    if (scope.register.confirm_password.$viewValue === scope.register.password.$viewValue) {
                        scope.register.confirm_password.$setValidity('passwordVerify', true);
                        scope.register.password.$setValidity('passwordVerify', true);
                    } else if (scope.register.confirm_password.$viewValue !== scope.register.password.$viewValue) {
                        scope.register.confirm_password.$setValidity('passwordVerify', false);
                        scope.register.password.$setValidity('passwordVerify', false);
                    }
                });
            }
         };
    });