<?php
/*
Aplicación Nº 33 ( ModificacionProducto BD)
Archivo: modificacionproducto.php
método:POST
Recibe los datos del producto(código de barra (6 cifras ),nombre ,tipo, stock, precio )por POST,
crear un objeto y utilizar sus métodos para poder verificar si es un producto existente, si ya existe el producto el stock se sobrescribe y se cambian todos los datos excepto: el código de barras .
Retorna un :
“Actualizado” si ya existía y se actualiza
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase
Apellido y Nombre: Lopez Carlos.
*/
include "Producto.php";

    if(isset($_POST["_codigo_de_barras"]) && isset($_POST["_nombre"]) && isset($_POST["_tipo"])  && 
    isset($_POST["_stock"]) && isset($_POST["_precio"]))
    {
            $auxCodigo = $_POST["_codigo_de_barras"];
            $auxNombre = $_POST["_nombre"];
            $auxTipo = $_POST["_tipo"];
            $auxStock = $_POST["_stock"];
            $auxPrecio = $_POST["_precio"];
            $auxProducto = new Producto();
            $auxProductoExistente = $auxProducto->TraerProductoPorCodigo($auxCodigo);
        if($auxProductoExistente->ModificarValoresProducto($auxNombre, $auxTipo, $auxStock,  $auxPrecio))
        {
            echo "Actualizado";
        }
        else 
        {
            echo "No se pudo hacer";
        }
    }
    else
    {
        echo "Ocurrio un error";
    }

?>

