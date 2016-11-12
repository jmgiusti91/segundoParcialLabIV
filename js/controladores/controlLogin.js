angular.module('app.controllers', [])

.controller("controlLogin", function($scope, $auth, UsuarioActual, $state, $rootScope){

	$scope.usuario = {};

	$scope.usuario.nombre = "nombreComprador";
	$scope.usuario.email = "comprador@comprador.com";
	$scope.usuario.clave = "1234";

	if ($auth.isAuthenticated()){
		console.info("getToken", $auth.getToken());
		console.info("token", $auth.getPayload());
	} else{
	    console.info("token", $auth.getPayload());
	    console.info("Factory Usuario Actual", UsuarioActual.getFullData());
	}

	$scope.IngresoComprador = function(){
		$scope.usuario.nombre = "nombreComprador";
		$scope.usuario.email = "comprador@comprador.com";
		$scope.usuario.clave = "1234";
	}


	$scope.IngresoVendedor = function(){
		$scope.usuario.nombre = "nombreVendedor";
		$scope.usuario.email = "vendedor@vendedor.com";
		$scope.usuario.clave = "1234";
	}

	$scope.IngresoAdmin = function(){
		$scope.usuario.nombre = "nombreAdministrador";
		$scope.usuario.email = "administrador@administrador.com";
		$scope.usuario.clave = "1234";
	}

	$scope.Guardar=function(){

	/*$auth.authenticate('github')
	  .then(function(response) {
	    alert(response);
	  })
	  .catch(function(response) {
	    alert(response);
	  });*/
	$auth.login($scope.usuario)
	  .then(function(response) {
	    console.info("correcto", response); //Sabemos que nos devuelve un token correcto SOLO CON EL ISAUTHENTICATED
	    if ($auth.isAuthenticated()){
	    	console.info("token", $auth.getPayload());
	    	UsuarioActual.login($auth.getPayload().nombre, $auth.getPayload().email,  $auth.getPayload().tipo);
	    	$rootScope.userActual = JSON.parse(UsuarioActual.getFullData());
	    	$rootScope.userActual.login = true;
	    	console.log($rootScope.userActual);
	    	$state.go('bienvenida');
	    }
	    else
	    	console.info("no token", $auth.getPayload());
	  })
	  .catch(function(response) {
	    console.info("NO volvio bien", response);
	  });

	}
	
})