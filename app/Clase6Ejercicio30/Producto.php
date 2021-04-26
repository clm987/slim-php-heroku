<?php
include "AccesoDatos.php";

class Producto
{
    public $_id;
    public $_codigo_de_barra;
    public $_nombre;
    public $_tipo;
    public $_stock;
    public $_precio;
    public $_fecha_de_creacion;
    public $_fecha_de_modificacion;

    public function __construct()   
    {

    }

    public function cargarDatosProducto($codigoDeBarra, $nombre, $tipo, $stock, $precio)
    {
        $this->_codigo_de_barra = $codigoDeBarra;
        $this->_nombre = $nombre;
        $this->_tipo = $tipo;
        $this->_stock = $stock;
        $this->_precio = $precio;
        $this->_fecha_de_creacion = $this->GenerarFecha();
        $this->_fecha_de_modificacion = $this->GenerarFecha();
    }
    public static function TraerTodosLosProductos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta(
                "select Id as _id, 
                codigo_de_barra as _codigo_de_barra,
                nombre as _nombre,
                tipo as _tipo,
                stock as _stock,
                precio as _precio,
                fecha_de_creacion as _fecha_de_creacion,
                fecha_de_modificacion as _fecha_de_modificacion
                from producto");
			$consulta->execute();	
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");		
	}

    public function InsertarProducto()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into producto (codigo_de_barra, nombre, tipo, stock, precio, fecha_de_creacion,fecha_de_modificacion)values('$this->_codigo_de_barra','$this->_nombre','$this->_tipo','$this->_stock','$this->_precio','$this->_fecha_de_creacion', '$this->_fecha_de_modificacion')");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

     public function GenerarFecha()
     {
         return $auxFecha = date("Y/m/d");
     }

	 public function InsertarProductoParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (codigo_de_barra, nombre, tipo, stock, precio, fecha_de_creacion,fecha_de_modificacion from producto)values(:codigo,:nombre,:tipo, :stock,:precio,:fechaDeCreacion,:fechaDeModificacion,)");

                $consulta->bindValue(':codigo',$this->_codigo_de_barra, PDO::PARAM_INT);
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
				$consulta->bindValue(':tipo', $this->_tipo, PDO::PARAM_STR);
				$consulta->bindValue(':stock', $this->_stock, PDO::PARAM_INT);
				$consulta->bindValue(':precio',$this->_precio, PDO::PARAM_STR);
				$consulta->bindValue(':fechaDeCreacion', $this->_fecha_de_creacion, PDO::PARAM_STR);
				$consulta->bindValue(':fechaDeModificacion', $this->_fecha_de_modificacion, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }


     public function ModificarStockProducto($auxProductoId, $auxNuevoStock)
     {
            $auxFechaModificacion = $this->GenerarFecha();
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
                update producto 
                set stock='$auxNuevoStock', fecha_de_modificacion= '$auxFechaModificacion'
                WHERE id='$auxProductoId'");
            return $consulta->execute();
     }

     public function verificarExistenciaProducto()
    {
         $_returnString = "";
         $_arrayDeUsuarios = [];
         $_arrayDeUsuarios = Producto::TraerTodosLosProductos();
 
         if($_arrayDeUsuarios != null && $_arrayDeUsuarios != false)
         {
             foreach ($_arrayDeUsuarios as $unProducto) 
             {
                 if($unProducto->_codigo_de_barra == $this->_codigo_de_barra)
                 {
                    if($this->actualizarStock($unProducto->_id, $unProducto->_stock, $this->_stock))
                        {
                            $_returnString = "Actualizado";
                            break;
                        }
                        else 
                        {
                            $_returnString = "Ocurrio un error al actualizar el producto. Revise los datos.";
                            break;
                        }
                 }
                 else
                 {
                    break;
                 }
             }

             try 
                { 
                    if($this->InsertarProducto()>0)
                    {
                        $_returnString = "Ingresado";
                    }
                    else
                    {
                        $_returnString = "Ocurrio un error al ingresar el producto";
                    }
                } 
                catch (PDOException $e) 
                { 
                    print "Error!: " . $e->getMessage(); 
                    die();
                }
         }
         else
         {
             $_returnString = "No hay productos cargados";
         }
             
         return $_returnString;
    }

    public function actualizarStock($auxId, $auxStock, $auxCantidad)
    {
        if($auxCantidad >0)
        {
            $auxNuevoStock = $auxStock + $auxCantidad;
            return $this->ModificarStockProducto($auxId, $auxNuevoStock);
        }
        else 
        {
            return false;    
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

   /* public function UsuarioToJson(Usuario $auxUsuario)    
    {
        $_auxVar = json_encode($auxUsuario);
        return $_auxVar;    
    }*/

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

   /* public function GuardarJson(Usuario $auxUsuario)
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

        
    }*/
}
