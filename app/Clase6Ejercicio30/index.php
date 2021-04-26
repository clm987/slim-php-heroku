<?php
/*
Aplicación Nº 30 ( AltaProducto BD)
Archivo: altaProducto.php
método:POST
Recibe los datos del producto(código de barra (6 sifras ),nombre ,tipo, stock, precio )por POST, carga la fecha de creación y crear un objeto ,se debe utilizar sus métodos para poder verificar si es un producto existente, si ya existe el producto se le suma el stock , de lo contrario se agrega .
Retorna un : “Ingresado” si es un producto nuevo
“Actualizado” si ya existía y se actualiza el stock.
“no se pudo hacer“ si no se pudo hacer
Hacer los métodos necesarios en la clase
Apellido y Nombre: Lopez Morantes Carlos. 
*/

include "Producto.php";

var_dump($_POST);

    if(isset($_POST["_codigo_de_barras"]) && isset($_POST["_nombre"]) && isset($_POST["_tipo"])  && 
    isset($_POST["_stock"]) && isset($_POST["_precio"]))
    {
            $auxCodigo = $_POST["_codigo_de_barras"];
            $auxNombre = $_POST["_nombre"];
            $auxTipo = $_POST["_tipo"];
            $auxStock = $_POST["_stock"];
            $auxPrecio = $_POST["_precio"];
            $auxProducto = new Producto();
            $auxProducto->cargarDatosProducto($auxCodigo, $auxNombre, $auxTipo, $auxStock,  $auxPrecio);
            $AuxStringMensaje = $auxProducto->verificarExistenciaProducto();
            print($AuxStringMensaje);
    }
    else
    {
        echo "Ocurrio un error";
    }

?>