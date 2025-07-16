<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumnos.class.php');

        // Iniciar la sesión
        session_start();

        $alumnos = new Alumnos();
        $id = $_SESSION['id_alumno'];
        $picto1 = $_POST['picto1d'];
        $picto2 = $_POST['picto2d'];
        $picto3 = $_POST['picto3d'];

        // Si el alumno existe con ese id y esa contraseña
        if($alumnos->comprobarAlumnoPictos($id, $picto1, $picto2, $picto3)){
            // Obtenemos el alumno 
            $alumnoActivo = $alumnos->obtenerAlumno($id);

            // Y almacenamos los datos del alumno en variables de sesión
            $_SESSION['nombre'] = $alumnoActivo['nombre'];
            $_SESSION['apellidos'] = $alumnoActivo['apellidos'];
            $_SESSION['aula'] = $alumnoActivo['aula'];
            $_SESSION['ruta_foto'] = $alumnoActivo['ruta_foto'];
            $_SESSION['perfil_visualizacion'] = $alumnoActivo['perfil_visualizacion'];
            $_SESSION['password'] = $alumnoActivo['password'];

            $_SESSION['sesion_alumno'] = true;
            
            // Devolvemos una respuesta al cliente
            echo "correcto";
        } else {
            // Devolvemos una respuesta al cliente
            echo "incorrecto";
        }
    }
?>