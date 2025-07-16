<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('profesores.class.php');

        $profesores = new Profesores();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $aula = $_POST['aula'];
        $ruta_foto = $_POST['ruta_foto'];

        // Insertamos los datos en la base de datos
        $profesores->insertarProfesor($nombre, $apellidos, $usuario, $password, $aula, $ruta_foto);
    }
?>