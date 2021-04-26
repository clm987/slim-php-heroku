<?php
include "AccesoDatos.php";

class Usuario
{
    private $_nombre;
    private $_apellido;
    private $_clave;
    private $_mail;
    private $_fechaDeRegistro;
    private $_localidad;


    public function __construct($nombre, $apellido, $clave, $mail, $fechaDeRegistro, $localidad)   
    {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_clave = $clave;
        $this->_mail = $mail;  
        $this->_fechaDeRegistro = $fechaDeRegistro;
        $this->_localidad = $localidad;
    }

    public function InsertarUsuario()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)values('$this->_nombre','$this->_apellido','$this->_clave','$this->_mail','$this->_fechaDeRegistro','$this->_localidad')");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

	 public function InsertarUsuarioParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into cds (titel,interpret,jahr)values(:titulo,:cantante,:anio)");
				$consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
				$consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
				$consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
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

        foreach ($arrayDeUsuarios as $key => $value) 
        {
            $stringDatos .= "<ul>". "<li>" . $value->UsuarioToList() . "</li>" . "</ul>";
        }
        return $stringDatos;

    }

      public function UsuarioToList()    
    {
        $dataString = "Nombre: " . $this->_nombre;
        $dataString .= "<li>";
        $dataString .= "Email: " . $this->_mail;
        $dataString .= "<li>";
        $dataString .= "Clave: " . $this->_clave;
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
