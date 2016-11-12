angular.module('app.controllers')

.controller('directivasCtrl', function($scope, $state, $timeout, UsuarioService, ProductoService, UsuarioActual){

	$scope.listadoUsuarios = [];

	$scope.listadoProductos = [];

	UsuarioService.traerTodos()
    	.then(function (respuesta){

    		console.info("todos los usuarios", respuesta);

    		$scope.listadoUsuarios = respuesta.data;

    	}).catch(function (error){

    		$scope.listadoUsuarios = [];

    	})

    ProductoService.traerTodos()
    	.then(function (respuesta){

    		console.info("todos los productos", respuesta);

    		$scope.listadoProductos = respuesta.data;

    	}).catch(function (error){

    		$scope.listadoProductos = [];

    	})

})