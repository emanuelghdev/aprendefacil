<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('tareas.class.php');
        require_once('alumnos.class.php');

        $tareas = new Tareas();

        // Obtenemos el id de la tarea, de los alumnos y las fechas de inicio y final
        $tarea_id = $_POST['tarea_id'];
        $alumnosSeleccionados = $_POST["alumnos_id"];
        $fechaIniSeleccionadas = $_POST["fecha_ini"];
        $fechaFinSeleccionadas = $_POST["fecha_fin"];

        $tareas->eliminarAlumnosTarea($alumnosSeleccionados, $tarea_id);

        // Si no hay ningún alumno seleccionado eliminamos los previamente introducidos
        if(!isset($_POST["alumnos_id"]) || empty($_POST["alumnos_id"])){
            $tareas->eliminarTareaAlumno($tarea_id);
        }
        else{
            // Iteramos sobre los valores seleccionados
            foreach ($alumnosSeleccionados as $alumno_id) {
                // Hallamos las fechas de inicio y de fin de la tarea para el alumno correspondiente
                $fecha_ini = $fechaIniSeleccionadas[$alumno_id];
                $fecha_fin = $fechaFinSeleccionadas[$alumno_id];

                // Insertamos los datos en la base de datos
                $tareas->asignarTarea($tarea_id, $alumno_id, $fecha_ini, $fecha_fin);
            }
        }

        header('Location: ../admin/admin_tareas.php');
    }
?>