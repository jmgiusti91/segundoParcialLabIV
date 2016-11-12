<?php
require_once"AccesoDatos.php";
class Usuario
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
	public $nombre;
  	public $email;
  	public $clave;
  	public $tipo;
  	//public $codFoto;

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetIdUsuario()
	{
		return $this->id;
	}
	public function GetNombre()
	{
		return $this->nombre;
	}
	public function GetEmail()
	{
		return $this->email;
	}
	public function GetClave()
	{
		return $this->clave;
	}
	public function GetTipo()
	{
		return $this->tipo;
	}

	/*public function getCodFoto()
	{
		return $this->codFoto;
	}*/


	public function SetIdUsuario($valor)
	{
		$this->id = $valor;
	}
	public function SetNombre($valor)
	{
		$this->nombre = $valor;
	}
	public function SetEmail($valor)
	{
		$this->email = $valor;
	}
	public function SetClave($valor)
	{
		$this->clave = $valor;
	}
	public function SetTipo($valor)
	{
		$this->tipo = $valor;
	}

	/*public function SetCodFoto($valor)
	{
		$this->codFoto = $valor;
	}*/
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($id=NULL)
	{
		if($id != NULL){
			$obj = Usuario::TraerUnUsuario($id);
			
			$this->nombre = $obj->nombre;
			$this->email = $obj->email;
			$this->clave = $obj->clave;
			$this->tipo = $obj->tipo;
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->nombre."-".$this->email."-".$this->clave."-".$this->tipo."-".$this->habilitado;
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnUsuario($idParametro) 
	{	


		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE id=:id");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerUnaPersona(:id)");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
					
	}
	
	public static function TraerTodosLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios ");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasPersonas() ");
		$consulta->execute();			
		$arrUsuarios= $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");	
		return $arrUsuarios;
	}

	public static function AutenticarUsuario($mailUsuario, $nombreUsuario, $claveUsuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE email=:email AND nombre=:nombre AND clave=:clave");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasPersonas() ");
		$consulta->bindValue(':email', $mailUsuario, PDO::PARAM_STR);
		$consulta->bindValue(':nombre', $nombreUsuario, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $claveUsuario, PDO::PARAM_STR);
		$consulta->execute();			
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
	}
	
	public static function BorrarUsuario($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id=:id");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL BorrarPersona(:id)");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
	
	public static function ModificarUsuario($usuario)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				UPDATE usuarios 
				SET email=:email,
				nombre=:nombre,
				clave=:clave,
				tipo=:tipo
				WHERE id=:id");
			//$consulta =$objetoAccesoDato->RetornarConsulta("CALL ModificarUsuario(:id,:nombre,:nombre,:email,:clave,:tipo)");
			$consulta->bindValue(':id',$usuario->id, PDO::PARAM_INT);
			$consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
			$consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
			$consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
			$consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);
			return $consulta->execute();
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function InsertarUsuario($usuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (email,nombre,clave,tipo)values(:email,:nombre,:clave,:tipo)");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL InsertarUsuario (:nombre,:nombre,:dni,:email,:clave,:tipo,:codFoto)");
		$consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
		$consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	
//--------------------------------------------------------------------------------//


}
