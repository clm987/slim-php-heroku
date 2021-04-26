<?php
/*
Aplicación Nº 29( Login con bd)
Archivo: Login.php
método:POST
Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado en la
base de datos,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario.
Apellido y Nombre: Lopez Carlos.
*/
include "Usuario.php";

if(isset($_POST["email"]) && isset($_POST["clave"]))
{
        $_auxMail = $_POST["email"];
        $_auxClave = $_POST["clave"];
        $_auxUsuario = new Usuario();
        $_auxUsuario->cargarDatosUsuario($_auxClave,  $_auxMail);
        $_auxString = $_auxUsuario->verificarUsuario();
        echo "$_auxString";
}
else
{
    echo "Ocurrio un error";
}

?>