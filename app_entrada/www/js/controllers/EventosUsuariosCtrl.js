app.controller('EventosUsuariosCtrl', function ($scope, $state,$http, $stateParams,EventoService,$ionicPopup) {
	$scope.nome_categoria = angular.uppercase($stateParams.nome_categoria);
	var eventos_id = $stateParams.id;
	$scope.Usuario = {};
        $scope.novo_usuario_show = false;
	
       
    $scope.getUsersFetchAll = function(pesquisar){
       
        EventoService.getUsersFetchAll($stateParams.id,pesquisar,$http,$scope);
    }
    $scope.confirmarEntrada = function(Usuario,pesquisar) {
        var alertPopup = $ionicPopup.alert({
            title: 'Nome: '+Usuario.nome+', Email: '+ Usuario.email,
            template: "<img src='http://eden-api.cursophprj.com.br/img/eventos/"+Usuario.img_documento+"'>",
            buttons: [{
                text: 'Cancel',
                type: 'button-default',
                onTap: function(e) {
                    //console.log(e);
                    //e.preventDefault();
                    //alert('cancelar!');
                }
            }, {
                text: 'Confirmar Entrada',
                type: 'button-balanced',
                onTap: function(e) {
					EventoService.confirmarEntrada(Usuario.id,eventos_id,$http,$scope,pesquisar);
                }
            }]
        });
    };
    $scope.entrou = function(Usuario) {
        var alertPopup = $ionicPopup.alert({
            title: 'Nome: '+Usuario.nome+', Email: '+ Usuario.email,
            template: "<img src='http://eden-api.cursophprj.com.br/img/eventos/"+Usuario.img_documento+"'>",
            buttons: [{
                text: 'Esse usuário já entrou na casa',
                type: 'button-balanced',
                onTap: function(e) {
                    //console.log(e);
                    //alert('confirmar!');

                }
            }]
        });
    };
	$scope.addUserEvent = function(Usuario,pesquisar) {
        EventoService.addUserEvent(Usuario,eventos_id,$http,$state,$scope,pesquisar);
    };
    $scope.novoUsuario = function(Usuario,pesquisar) {
        $scope.Usuario.nome = pesquisar;
        $scope.pesquisar    = pesquisar;
        var alertPopup = $ionicPopup.alert({
            title: 'Novo Usuário',
            templateUrl: 'templates/novo_usuario.html',
	    scope: $scope,
            buttons: [{
                text: 'Cancel',
                type: 'button-default',
                onTap: function(e) {
                    //console.log(e);
                    //e.preventDefault();
                    //alert('cancelar!');
                }
            },
            {
                text: 'Inserir',
                type: 'button-balanced',
                onTap: function(e) {
                        $scope.addUserEvent(Usuario,pesquisar);
			
                }
            }]
        });
    };
});
