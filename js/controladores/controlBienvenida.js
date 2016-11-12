angular.module('app.controllers')

.controller('BienvenidaCtrl', function($scope, $state, $timeout, UsuarioActual){

	$scope.usuario = JSON.parse(UsuarioActual.getFullData());

})