angular.module('app.controllers')

.controller('altaProductosCtrl', function($scope, $state, $timeout, UsuarioActual, ProductoService){

	$scope.usuario = JSON.parse(UsuarioActual.getFullData());

	$scope.producto = {};

	$scope.Guardar = function(){

		var producto = JSON.stringify($scope.producto);

		console.info("producto", $scope.producto);

		ProductoService.insertarProducto(producto)
			.then(function (respuesta){

				console.info("respuesta", respuesta);

				$state.go('grillaProductos');

			}).catch(function (error){
				console.info("error", error);
			})

	}

})