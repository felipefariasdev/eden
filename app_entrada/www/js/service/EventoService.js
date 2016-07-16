app.service('EventoService', function() {
    
	var url_admin_api = "http://admin-eden.cursophprj.com.br/wp-json/wp/v2/";
	var url_api = "http://eden-api.cursophprj.com.br/";
	
	this.getEventosAll = function ($http,$scope) {
		$http.get(url_admin_api+'posts').success(function(response) {
			$scope.data = (response);
		});
    }
	this.getEventosId = function (value,$http,$scope) {
        $http.get(url_admin_api+'posts/'+value).success(function(response) {
            $scope.data = (response);
        });
    }
	this.confirmarEntrada = function (usuarios_id,eventos_id,$http,$scope,pesquisar) {
		
		$http.post(url_api+'usuario/confirmar_entrada',{'usuarios_id':usuarios_id,'eventos_id':eventos_id}).success(function(response) {
			$scope.getUsersFetchAll(pesquisar);
		});
		
    }
    this.getUsersFetchAll = function (eventos_id,pesquisar,$http,$scope) {
		if(pesquisar){
			$http.get(url_api+'usuario_evento/list/'+eventos_id+'/'+pesquisar).success(function(response) {
				$scope.qtdUsersPesquisa = (response.rowCount);
				$scope.data_usuarios = (response.data_usuarios);
			});
		}
    }
	this.addUserEvent = function(Usuario,eventos_id,$http,$state,$scope,pesquisar){
		var user = new FormData();
		user.append('img_documento', Usuario.img_documento);
		user.append('nome', Usuario.nome);
		user.append('email', Usuario.email);
		user.append('eventos_id', eventos_id);
		
		$http.post(url_api+'usuario/insert/', user, {
		  transformRequest: angular.identity,
		  headers: {'Content-Type': undefined}
		})
		  .success(function(resAddUserEvent){
                        $scope.Usuario = {};
                        if(resAddUserEvent.success){
                            alert("Adicionado com sucesso!");
                            $scope.getUsersFetchAll(pesquisar);
                            return true;
                        }else{
                            alert("Erro: Preencha todos os campos");
                            return false;
                            
                        }
		  })
		  .error(function(){
		  });
    };
});