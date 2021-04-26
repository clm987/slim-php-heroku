<?php
/*
Aplicación Nº 32(Modificacion BD)
Archivo: ModificacionUsuario.php
método:POST
Recibe los datos del usuario(nombre, clavenueva, clavevieja,mail )por POST , crear un objeto y utilizar sus métodos para poder hacer la modificación, guardando los datos la base de datos
retorna si se pudo agregar o no.
Solo pueden cambiar la clave
Apellido y Nombre: Lopez Carlos.
*/
include "Usuario.php";
include "AccesoDatos.php";

if(isset($_POST["nombre"]) && isset($_POST["claveNueva"]) && isset($_POST["claveVieja"]) && isset($_POST["email"]))
{
        $_auxNombre = $_POST["nombre"];
        $_auxClaveNueva = $_POST["claveNueva"];
        $_auxClaveVieja = $_POST["claveVieja"];
        $_auxMail = $_POST["email"];
        $_auxUsuario = new Usuario();
        $_auxUsuario->cargarDatosUsuario($_auxClaveVieja,  $_auxMail);
        $_auxString = $_auxUsuario->verificarUsuario();
        if($_auxString == "Usuario Verificado")
        {
            if($_auxUsuario->modificarUsuario($_auxMail, $_auxClaveNueva))
            {
                echo "clave modificada con exito";
            }
            else 
            {
                echo "no se pudo modificar la clave";    
            }
        }
        else 
        {
            echo  "$_auxString";  
        }
}
else
{
    echo "Ocurrio un error";
}

?>