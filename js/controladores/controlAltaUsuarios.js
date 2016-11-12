angular.module('app.controllers')

.controller('altaUsuariosCtrl', function($scope, $state, $timeout, UsuarioActual, UsuarioService){

	$scope.usuario = JSON.parse(UsuarioActual.getFullData());

	$scope.user = {};

	$scope.user.tipo = 'invalido';

	$scope.Guardar = function(){

		var user = JSON.stringify($scope.user);

		console.info("user", $scope.user);

		UsuarioService.insertarUsuario(user)
			.then(function (respuesta){

				console.info("respuesta", respuesta);

				$state.go('grillaUsuarios');

			}).catch(function (error){
				console.info("error", error);
			})

	}

})