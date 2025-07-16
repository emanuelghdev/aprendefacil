<?php
    // Iniciar la sesión
    session_start();

    // Destruir la sesión actual
    session_destroy();

    // Redirigimos al usuario a la página principal
    header("Location: ../index.php");
?>