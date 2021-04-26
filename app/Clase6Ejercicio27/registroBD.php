<?php
/*
Aplicación Nº 27 (Registro BD) 
Archivo: registro.php
método:POST
Recibe los datos del usuario( nombre,apellido, clave,mail,localidad )por POST, crear un objeto con la fecha de registro y utilizar sus métodos para poder hacer el alta, guardando los datos  la base de datos 
retorna si se pudo agregar o no.
Apellido y Nombre: Lopez Morantes Carlos. 
*/

include "usuario.php";

var_dump($_POST);

    if(isset($_POST["_nombre"]) && isset($_POST["_apellido"]) && isset($_POST["_clave"])  && 
    isset($_POST["_mail"]) && isset($_POST["_fechaDeIngreso"]) && isset($_POST["_localidad"]))
    {
            $auxNombre = $_POST["_nombre"];
            $auxApellido = $_POST["_apellido"];
            $auxClave = $_POST["_clave"];
            $auxMail = $_POST["_mail"];
            $auxFechaDeIngreso = $_POST["_fechaDeIngreso"];
            $auxLocalidad = $_POST["_localidad"];
            $auxUsuario = new Usuario($auxNombre, $auxApellido, $auxClave, $auxMail, $auxFechaDeIngreso,$auxLocalidad);
            if($auxUsuario->InsertarUsuario() > 0)
            {
                echo "Datos guardados correctamente";
            }
            else 
            {
                echo "Se produjo un error al guardar el usuario";    
            }
    }
    else
    {
        echo "Ocurrio un error";
    }

?>