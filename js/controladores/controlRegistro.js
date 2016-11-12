angular.module('app.controllers')

.controller('controlRegistro', function($scope, $state, $timeout, ClienteService){

	$scope.cliente = {};
	$scope.cliente.nombre = "Jacinto";
	$scope.cliente.telefono = 42228888;
	$scope.cliente.email = "cliente1@cliente1.com"
	$scope.cliente.clave = 1234;
	$scope.cliente.copiaclave = 1234;

	$scope.Guardar = function(){

		$scope.cliente.habilitado = true;

		var cliente = JSON.stringify($scope.cliente);

		ClienteService.insertarCliente(cliente)
			.then(function (respuesta){

				console.info("Respuesta", respuesta);

			}).catch(function (error){

				console.info("Error", error);

			})

	}


	$scope.Loguearme = function(){

		$timeout(function (){

			$state.go('log.login');

		}, 500)
		

	}

})