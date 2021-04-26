<?php
include "AccesoDatos.php";

class Usuario
{
    public $_id;
    public $_nombre;
    public $_apellido;
    public $_clave;
    public $_mail;
    public $_fechaDeRegistro;
    public $_localidad;

    public function __construct()   
    {

    }

    public function cargarDatosUsuario($clave, $email)
    {
        $this->_clave = $clave;
        $this->_mail = $email;
    }
    public static function TraerTodosLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta(
                "select Id, 
                nombre as _nombre,
                apellido as _apellido,
                clave as _clave,
                mail as _mail,
                fecha_de_registro as _fechaDeRegistro,
                localidad as _localidad
                from usuario");
			$consulta->execute();	
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

    public function InsertarUsuario()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)values('$this->_nombre','$this->_apellido','$this->_clave','$this->_mail','$this->_fechaDeRegistro','$this->_localidad')");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

     public function GenerarFecha()
     {
         return $auxFecha = date("Y/m/d");
     }

	 public function InsertarUsuarioParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad from usuario)values(:titulo,:cantante,:anio)");
				$consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
				$consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
				$consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

     public function verificarUsuario()
     {
         $_returnString = "";
         $_arrayDeUsuarios = [];
         $_arrayDeUsuarios = Usuario::TraerTodosLosUsuarios();
 
         if($_arrayDeUsuarios != null)
         {
             foreach ($_arrayDeUsuarios as $value) 
             {
                 if($value->_mail == $this->_mail)
                 {
                         
                     if($value->_clave == $this->_clave)
                     {
                         return $_returnString ="Usuario Verificado";
                     }
                 else
                     {
                         return $_returnString ="Error de datos";
                     }
                 }
             }
         }
         else
         {
             $_returnString = "No hay usuarios cargados";
         }
             
                 
         if($_returnString == "")
         {
             return "Usuario no registrado";
         }
     }

    public function UsuarioToCsv()    
    {
        $dataString = $this->_nombre;
        $dataString .= ",";
        $dataString .= $this->_mail;
        $dataString .= ",";
        $dataString .= $this->_clave;
        $dataString .= "\n";
        return $dataString;    
    }

    public function UsuarioToJson(Usuario $auxUsuario)    
    {
        $_auxVar = json_encode($auxUsuario);
        return $_auxVar;    
    }

    public static function ArmarListado($arrayDeUsuarios = [])
    {
        $stringDatos = "";

        foreach ($arrayDeUsuarios as $key => $unUsuario) 
        {
            $stringDatos .= "<ul>". "<li>" . $unUsuario->UsuarioToList() . "</li>" . "</ul>";
        }
        return $stringDatos;

    }

      public function UsuarioToList()    
    {
        $dataString = "Nombre: " . $this->_nombre;
        $dataString .= "<li>";
        $dataString = "Apellido: " . $this->_apellido;
        $dataString .= "<li>";
        $dataString = "Clave: " . $this->_clave;
        $dataString .= "<li>";
        $dataString .= "Email: " . $this->_mail;
        $dataString .= "<li>";
        $dataString .= "Fecha de Registro: " . $this->_fechaDeRegistro;
        $dataString .= "<li>";
        $dataString .= "Localidad: " . $this->_localidad;
        $dataString .= "<li>";
        return $dataString;    
    }

    public function GuardarJson(Usuario $auxUsuario)
    {
        $auxArchivo = fopen("usuarios.json", "a");
        echo "<br>";
        echo "$auxUsuario->_ruta";
        if($auxArchivo != null)
        {
            fputs($auxArchivo, $this->UsuarioToJson($auxUsuario));
            fclose($auxArchivo);
            return true;
        }
        else
        {
           return false;
        }   
    }

    public function Guardar()
    {
        $auxArchivo = fopen("usuarios.csv", "a");
        if($auxArchivo != null)
        {
            fputs($auxArchivo, $this->UsuarioToCsv());
            fclose($auxArchivo);
            return true;

        }
        else
        {
           return false;
        }

        
    }
}
