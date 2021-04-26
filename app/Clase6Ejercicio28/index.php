<?php
/*
Aplicación Nº 28 ( Listado BD)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,ventas)
cada objeto o clase tendrán los métodos para responder a la petición
devolviendo un listado <ul> o tabla de html <table>
Apellido y Nombre: Lopez Carlos.
*/
include "Usuario.php";

$_archivo = $_GET["archivo"];

if(isset($_archivo) != false)
{

    switch ($_archivo) 
    {
        case 'usuarios':
            $_arrayDeUsuarios = [];
            $_arrayDeUsuarios = Usuario::TraerTodosLosUsuarios();
            $auxString = Usuario::ArmarListado($_arrayDeUsuarios); 
            echo "$auxString";
            break;        
        default:
            echo "Por ahora solo hay usuarios";
            break;
    }
}

?>