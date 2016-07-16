var app = angular.module('app', ['ionic']);


app.run(function ($ionicPlatform) {
    $ionicPlatform.ready(function () {
        // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
        // for form inputs)

        if (window.cordova && window.cordova.plugins.Keyboard) {
            cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        }
        if (window.StatusBar) {
            StatusBar.styleDefault();
        }
    });
})

app.config(function ($stateProvider, $urlRouterProvider) {
    $stateProvider

    .state('app', {
        url: '/app',
        abstract: true,
        templateUrl: 'templates/menu.html',
        controller: 'AppCtrl'
    })
    .state('app.eventos', {
        url: '/eventos',
        views: {
            'menuContent': {
                templateUrl: 'templates/eventos.html',
                controller: 'EventosCtrl'
            }
        }
    })
    .state('app.eventos_detalhe', {
        url: '/eventos/{id}',
        views: {
            'menuContent': {
                templateUrl: 'templates/eventos_detalhe.html',
                controller: 'EventosCtrl'
            }
        }
    })
    .state('app.eventos_usuarios', {
        url: '/eventos_usuarios/{id}',
        views: {
            'menuContent': {
                templateUrl: 'templates/eventos_usuarios.html',
                controller: 'EventosUsuariosCtrl'
            }
        }
    })
    ;

  $urlRouterProvider.otherwise('/app/eventos');
});
