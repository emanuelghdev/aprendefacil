<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('profesores.class.php');

        $profesores = new Profesores();
        $usuario = $_POST['usuario-login'];
        $password = $_POST['password-login'];

        // Iniciar la sesión
        session_start();

        // Indicamos que el formulario ha sido enviado
        $_SESSION['formularioEnviado-login'] = true;

        // Si el profesor existe con ese nombre de usuario y esa contraseña
        if($profesores->comprobarProfesor($usuario, $password)){
            // Obtenemos el usuario 
            $profesorActivo = $profesores->obtenerProfesor($usuario);

            // Y almacenamos los datos del usuario en variables de sesión
            $_SESSION['nombre'] = $profesorActivo['nombre'];
            $_SESSION['apellidos'] = $profesorActivo['apellidos'];
            $_SESSION['aula'] = $profesorActivo['aula'];
            $_SESSION['ruta_foto'] = $profesorActivo['ruta_foto'];
            $_SESSION['usuario'] = $profesorActivo['usuario'];
            $_SESSION['password'] = $profesorActivo['password'];
            $_SESSION['id_prof'] = $profesorActivo['id'];

            // Comprueba si las credenciales son válidas para el administrador
            if ($profesores->esAdministrador($usuario) === true) {
                // Inicio de sesión exitoso, se crea una sesión para el administrador
                $_SESSION["admin"] = true;

                header("Location: ../admin/admin_tareas.php");
            }
            else{
                // Redirigimos al profesor a la página correspondiente
                header("Location: ../profesores/profesor_tareas.php");
            }
        }
        else{
            // Si se falla el login redirigimos al usuario a la página principal
            header("Location: ../profesores/acceso_profesores.php");
        }
    }
?>