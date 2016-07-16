app.service('EventoService', function() {
    this.getEventosAll = function ($http,$scope) {
		$http.get('http://admin-eden.cursophprj.com.br/wp-json/wp/v2/posts').success(function(response) {
			$scope.data = (response);
		});
    }
	this.getEventosId = function (value,$http,$scope) {
        $http.get('http://admin-eden.cursophprj.com.br/wp-json/wp/v2/posts/'+value).success(function(response) {
            $scope.data = (response);
        });
    }
});