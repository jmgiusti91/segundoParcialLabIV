angular
  .module('app')
  .factory('factoryRutas', function (){
  	var objeto = {};

    objeto.nombre = "Factory de rutas";

    objeto.RutaProductos = 'http://localhost:8080/LAB-IV/segundo_parcial/segundoParcialLabIV/ws1/productos/';

    objeto.RutaUsuarios = 'http://localhost:8080/LAB-IV/segundo_parcial/segundoParcialLabIV/ws1/usuarios/';

    return objeto;


    
  })