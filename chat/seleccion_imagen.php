<?php
    if(isset($_POST['page']))
    {
        $directorio = "../multimedia/imagenes_chat";
        $page = $_POST['page'];
        $itemsPerPage = 10; 					// Número de elementos por página           

        // Verificamos que la carpeta exista
        if (is_dir($directorio)) {
            // Obtenemos la lista de archivos en la carpeta
            $archivos = scandir($directorio);
            $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');

            $archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
                $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                return in_array(strtolower($extension), $extensiones_permitidas);
            });

            // Mostramos los archivos de la página actual
            $start = ($page - 1) * $itemsPerPage;
            $end = $start + $itemsPerPage - 1;

            $count = 0;

            foreach ($archivos_filtrados as $archivo) {
                $archivostr = '"'.$archivo.'"';
                if ($count >= $start && $count <= $end) {
                    echo "<button class='pictograma' name='input_mensaje' onClick='select(\"$archivo\")' value='" . $archivo . "'>
                    <img src='" . $directorio . "/" . $archivo . "' alt='" . $archivo . "' title='" . $archivo . " style='width:50px'></button>";
                }
                $count++;
            }
        }
    }
?>