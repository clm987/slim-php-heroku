<?php
include "Usuario.php";
include "Producto.php";

class Venta
{

public $_Id;
public $_Id_producto;
public $_Id_usuario;
public $_cantidad;
public $_Fecha_de_venta;

public function __construct()
{
    
}

public function cargarDatosVenta($idProducto, $idUsuario, $cantidad)
{
        $this->_Id_producto = $idProducto;
        $this->_Id_usuario = $idUsuario;
        $this->_cantidad = $cantidad;
        $this->_Fecha_de_venta = $this->GenerarFecha();
}

public function GenerarFecha()
{
         return date("Y/m/d");
}

public function InsertarVenta()
{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into venta (Id,Id_producto,Id_usuario,cantidad,Fecha_de_venta)values('$this->_Id','$this->_Id_producto','$this->_Id_usuario','$this->_cantidad','$this->_Fecha_de_venta')");
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
}


















}
















?>