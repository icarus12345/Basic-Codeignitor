angular.module('loader', [])

    .directive('loader', function($window, $timeout,$rootScope) {

        var canvas, ctx;
        var promise;

        var SIZE = 3;
        var FPS = 1000 / 60;
        var BACKGROUND = '#FFF';
        var COLOR = '#4CAF50';

        var t = 100, a;
        var points = new Array(5);

        function create() {
            canvas.style.display = '';
            canvas.width = window.innerWidth;
            a = 2 * canvas.width / (t * t);
            for (var i = 0; i < points.length; i++) {
                points[i] = t / points.length * i;
            }
        }

        function draw() {
            ctx.fillStyle = BACKGROUND;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            for (var i = 0; i < points.length; i++) {
                points[i]++;
                if (points[i] > t) {
                    points[i] = 0;
                }
                ctx.fillStyle = COLOR;
                ctx.fillRect(a * points[i] * points[i] * 0.5, 0, SIZE, SIZE);
            }
        }

        function clear() {
            ctx.clearRect(0, 0, canvas.width, SIZE);
            canvas.style.display = 'none';
        }

        function animate() {
            canvas.style.display = '';
            draw();
            promise = $timeout(animate, FPS);
        }

        function toggle(val) {
            if (val) {
                animate();
            } else {
                $timeout.cancel(promise);
                clear();
            }
        }

        return function($scope, element) {

            canvas = element[0];
            canvas.height = SIZE;
            ctx = canvas.getContext('2d');

            create();

            $scope.$watch(function() {
                return $rootScope.loading > 0;
            }, toggle);

            angular.element($window).bind('resize', create);

        }

    });
