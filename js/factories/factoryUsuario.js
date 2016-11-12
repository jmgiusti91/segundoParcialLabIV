angular
	.module('app')
	.factory('UsuarioActual', [function(){

		var nombre = "";
		var email = "";
		var tipo = "";

		return {

			login:function(name,mail,type){

				nombre = name;
				email = mail;
				tipo = type;

			},getName:function(){
				return nombre;
			},getEmail:function(){
				return email;
			},getTipo:function(){
				return tipo;
			},getFullData:function(){
				var jsonUsuario = {};
				jsonUsuario.nombre = nombre;
				jsonUsuario.email = email;
				jsonUsuario.tipo = tipo;

				return JSON.stringify(jsonUsuario);
			}

		};

	}])