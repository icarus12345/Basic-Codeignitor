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
        // 'ngAnimate',
        'mobile-angular-ui',
        'loader',
        'vesparny.fancyModal',
        // touch/drag feature: this is from 'mobile-angular-ui.gestures.js'.
        // This is intended to provide a flexible, integrated and and
        // easy to use alternative to other 3rd party libs like hammer.js, with the
        // final pourpose to integrate gestures into default ui interactions like
        // opening sidebars, turning switches on/off ..
        'mobile-angular-ui.gestures',
        // 'ngTouch',
        'ngTap',
        'chart.js',
        'ngMaterial'
    ])

    .run(function($transform,$rootScope, $location, $routeParams, $window) {
        window.$transform = $transform;
        $rootScope.$on('$routeChangeSuccess', function(event, current, previous) {
            $rootScope.__path = $location.path()
            var fullRoute = current.$$route.originalPath;
            $rootScope.__fullRoute = fullRoute;
            $rootScope.__backPage = $rootScope.__frontPage;
            switch(fullRoute){
                case '/':
                    $rootScope.__level = 0;
                    $rootScope.__prevLevel = $rootScope.__level || 0;
                    $rootScope.__frontPage = 'home';
                    break;
                case '/project/:projectId':
                    $rootScope.__level = 1;
                    $rootScope.__prevLevel = $rootScope.__level || 0;
                    $rootScope.__frontPage = 'project';
                    break;
                case '/project/:projectId/cat/:categoryId':
                    $rootScope.__level = 1;
                    $rootScope.__prevLevel = $rootScope.__level || 0;
                    $rootScope.__frontPage = 'project';
                    break;
                case '/project/:projectId/quest/:categoryId':
                    $rootScope.__level = 1;
                    $rootScope.__prevLevel = $rootScope.__level || 0;
                    $rootScope.__frontPage = 'project';
                    break;
                case '/project/:projectId/chart/:categoryId':
                    $rootScope.__level = 1;
                    $rootScope.__prevLevel = $rootScope.__level || 0;
                    $rootScope.__frontPage = 'project';
                    break;
                case '/share/:projectId':
                    $rootScope.__level = 1;
                    $rootScope.__prevLevel = $rootScope.__level || 0;
                    $rootScope.__frontPage = 'project';
                    break;
            }
            console.log(fullRoute);
        });
        $rootScope.goBack = function(){
            $window.history.back();
            // history.back();
            // rootScope.$apply();
        }
      // Get all URL parameter
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
        $routeProvider.when('/project/:projectId', {
            templateUrl: 'template/project-detail.html',
            reloadOnSearch: false,
            controller: 'ProjectController'
        });
        $routeProvider.when('/project/:projectId/cat/:categoryId', {
            templateUrl: 'template/project-detail.html',
            reloadOnSearch: false,
            controller: 'ProjectController'
        });
        $routeProvider.when('/project/:projectId/quest/:categoryId', {
            templateUrl: 'template/questions.html',
            reloadOnSearch: false,
            controller: 'QuestionController'
        });
        $routeProvider.when('/project/:projectId/chart/:categoryId', {
            templateUrl: 'template/chart.html',
            reloadOnSearch: false,
            controller: 'ChartController'
        });
        $routeProvider.when('/share/:projectId', {
            templateUrl: 'template/share.html',
            reloadOnSearch: false,
            controller: 'ShareController'
        });
    })

    .factory('StorageService', StorageFactory)
    .factory('Auth', AuthFactory)
    .factory('API', APIFactory)
    .factory('CategoryService', CategoryFactory)
    .factory('ProjectService', ProjectFactory)
    .factory('QuestionService', QuestionFactory)
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
    })