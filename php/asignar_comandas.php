<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumnos.class.php');

        $alumnos = new Alumnos();

        // Obtenemos el id del alumnos
        $id = $_POST['id'];

        // Asignamos o desasignamos según nos convenga a ese alumno encargado de las comandas
        if($alumnos->esEncargado($id)){
            $encargo = $alumnos->asignarComandas($id, false);
        }
        else{
            $encargo = $alumnos->asignarComandas($id, true);
        }
        
        echo $encargo;
    }
?>