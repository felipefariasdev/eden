app.controller('EventosCtrl', function ($scope, $http, $stateParams,EventoService) {
	$scope.nome_categoria = angular.uppercase($stateParams.nome_categoria);
	$scope.getEventosAll = function(){
		EventoService.getEventosAll($http,$scope);
	}
	$scope.getEventosId = function(){
		EventoService.getEventosId($stateParams.id,$http,$scope);
	}
});
