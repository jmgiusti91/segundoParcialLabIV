<?php
use Slim\Http\Headers;
header('Content-Type: image/jpeg');
include_once('servidor/Usuarios.php');
include_once('servidor/Productos.php');
/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
require 'vendor/autoload.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
/*$app = new Slim\App();*/
$app = new Slim\App(['settings' => ['displayErrorDetails' => true]]);



/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
/**
* GET: Para consultar y leer recursos
* POST: Para crear recursos
* PUT: Para editar recursos
* DELETE: Para eliminar recursos
*
*  GET: Para consultar y leer recursos */

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080/LAB-IV/segundo_parcial/segundoParcialLabIV/')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to Slim!");
    return $response;
});

$app->get('/productos[/]', function ($request, $response, $args) {
    $datos = Producto::TraerTodosLosProductos();
    $response->write(json_encode($datos)); /*No puedo pasar un objeto referencial a la memoria RAM del servidor a la memoria RAM del cliente.. Por eso, tengo que encondearlo a JSON.*/
    
    return $response;
});

$app->get('/usuarios[/]', function ($request, $response, $args) {
    
    $datos = Usuario::TraerTodosLosUsuarios();
    $response->write(json_encode($datos));

    return $response;
});
/* POST: Para crear recursos */
$app->post('/productos/{objeto}', function ($request, $response, $args) {
    $producto = json_decode($args['objeto']);

    Producto::InsertarProducto($producto);
    
    $response->write($args['objeto']);
}); /*Desde el cliente vamos a pasar un string.. Aca, en PHP, lo vamos a tomar encodear a JSON y tener listo el obj PHP..
    Vamos a tener que cambiar usuario y vamos a tener que devolver un JSON encodeado de TraerTodasLasPersonas. Eso lo vamos a devolver al AJAX */


/*$app->post('/archivo[/]', function ($request, $response, $args) {
    //var_dump($request);
    
    try {

    $temporal = $_FILES[ 'file' ][ 'tmp_name' ];
    $datos = Persona::TraerTodasLasPersonas();
    if(is_null($datos)){
        $nuevoCodFoto = 1;
    } else{
        $nuevoCodFoto = intval($datos[count($datos) - 1]->codFoto);
        $nuevoCodFoto++;
    }
    
    $nombreFoto = explode(".", $_FILES['file']['name']);
    $archivoTmp = $nombreFoto[0]. " - ".$nuevoCodFoto . ".jpg";

    $ruta = "..". DIRECTORY_SEPARATOR . 'fotos' . DIRECTORY_SEPARATOR . $archivoTmp;
    //$dst = $path . $_FILES['photoimg']['name'];

    if (($img_info = getimagesize($temporal)) === FALSE) //Este codigo lo utilizamos para cambiar tamaño de imagen
      die("Image not found or not an image");

    $width = $img_info[0];
    $height = $img_info[1];

    switch ($img_info[2]) {
      case IMAGETYPE_GIF  : $src = imagecreatefromgif($temporal);  break;
      case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($temporal); break;
      case IMAGETYPE_PNG  : $src = imagecreatefrompng($temporal);  break;
      case IMAGETYPE_BMP  : $src = imagecreatefromwbmp($temporal);  break;
      default : die("Unknown filetype");
    }

    $nuevoWidth = 1200;
    $nuevoHeight = 800;

    $tmp = imagecreatetruecolor($nuevoWidth, $nuevoHeight);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $nuevoWidth, $nuevoHeight, $width, $height);
    imagejpeg($tmp, $ruta);


    $rutaMod = "..". DIRECTORY_SEPARATOR . 'fotosModificar' . DIRECTORY_SEPARATOR . $archivoTmp;
    copy($ruta, $rutaMod);

    } catch (Exception $e) {
        echo $e->message;
    }
    return $response;
}); Desde el cliente vamos a pasar un string.. Aca, en PHP, lo vamos a tomar encodear a JSON y tener listo el obj PHP..*/

$app->post('/usuarios/{objeto}', function ($request, $response, $args) {

    $usuario = json_decode($args['objeto']);

    Usuario::InsertarUsuario($usuario);
    
    $response->write($args['objeto']);
}); 

// /* PUT: Para editar recursos */
$app->put('/usuarios/{objeto}', function ($request, $response, $args) {

    $usuario = json_decode($args['objeto']);
    //$archivoTmp = $persona->foto1. " - ".$persona->codFoto . ".jpg";
    
    Usuario::ModificarUsuario($usuario);
    
    $response->write($args['objeto']);
});

// /* DELETE: Para eliminar recursos */
$app->delete('/productos/{id}', function ($request, $response, $args) {
    Producto::BorrarProducto($args['id']);
    return $response;
});

$app->delete('/usuarios/{id}', function ($request, $response, $args) {
    Usuario::BorrarUsuario($args['id']);
    return $response;
});
/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
