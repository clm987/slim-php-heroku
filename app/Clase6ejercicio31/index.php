<?php
/*
Aplicación Nº 31 (RealizarVenta BD )
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems ,por
POST . Verificar que el usuario y el producto exista y tenga stock.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en las clases
Apellido y Nombre: Lopez Carlos.
*/

include "Venta.php";
include "AccesoDatos.php";

if(isset($_POST["codigo_de_barra"]) && isset($_POST["usuario_id"]) && isset($_POST["cantidad"]))
{
    $_auxCodigo = $_POST["codigo_de_barra"];
    $_auxUsuario = $_POST["usuario_id"];
    $_auxCantidad = $_POST["cantidad"];
    $_auxString = "";
    if(Usuario::validarExistenciaUsuario($_auxUsuario))
    {
        $auxProducto = Producto::ValidarStockProducto($_auxCodigo, $_auxCantidad);
        if($auxProducto != null)
        {
            $_auxVenta = new Venta();
            $_auxVenta->cargarDatosVenta($auxProducto->_id, $_auxUsuario, $_auxCantidad);
            if($_auxVenta->InsertarVenta() > 0)
            {
                if($auxProducto->disminuirStock($auxProducto->_id, $auxProducto->_stock, $_auxCantidad))
                {
                    $_auxString = "Venta realizada";
                }
                
            }
            else 
            {
                $_auxString = "No se pudo hacer";
            }
        }
        else 
        {
            $_auxString = "Producto inexistente";
        }
    }
        echo "$_auxString";
}
else
{
    echo "Ocurrio un error";
}

?>

