<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Acceso de personal</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
        <script src="../javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
        <link rel="stylesheet" type="text/css" href="../css/acceso.css">
	</head>

	<body>
		<header>
            <div id="div-header">
                <div></div>
			    <div id='div-titulo' class="sin-barra-lateral"><img src='../multimedia/imagenes/icono_login.png' width='60' height='60' alt='Icono inicio de sesion'>
                <h1 id="tituloPrincipal">Acceso</h1></div>
                <div></div>
            </div>
		</header>

		<main>
            <a href="../index.php" class="boton-volver">&#129152;</a>

            <div id="form-container">
                <article id="form-login">
                    <form onsubmit="return validarFormularioLoginProfesor(event, '-login')" action="../php/login_profesores.php" method="POST" class="formulario">
                        <label for="usuario-login">Usuario:</label>
                        <input type="text" id="usuario-login" name="usuario-login" required>
                        <p id="usuario-login-incorrecto" style="display:none;">El usuario no tiene un formato v&aacute;lido</p>
                        <br>
                        <label for="password-login">Contrase&ntilde;a:</label>
                        <input type="password" id="password-login" name="password-login" required>
                        <p id="password-login-incorrecto" style="display:none;">La contrase&ntilde;a no tiene un formato v&aacute;lido</p>
                        <br>
                        <input type="submit" value="Iniciar sesi&oacute;n">
                    </form>
                    <p id="-login-incorrecto" style="display:none;">La contrase&ntilde;a o el nombre de usuario son incorrectos. Int&eacute;ntalo de nuevo.</p>
                </article>
            </div>

            <?php
                // Iniciar la sesión
                session_start();

                // Si hay una sesión activa de administrador redirigimos a la página del administradors
                if (isset($_SESSION['admin'])) {
                    header("Location: ../admin/admin_tareas.php");
                }
                else if (isset($_SESSION['usuario'])) {		// Si hay una sesión activa de usuario, redirigimos a la página de profesorado
                    header("Location: ../profesores/profesor_tareas.php");
                }
                else if(isset($_SESSION['formularioEnviado-login']) && $_SESSION['formularioEnviado-login'] == true){	// Si no hay ninguna sesión activa
                    // Mostramos un mensaje de error
                    echo "<script>recuperarElemento('-login-incorrecto');</script>";

                    $_SESSION['formularioEnviado-login'] = false;
                }
            ?>
		</main>

		<footer>
    	</footer>
	</body>
</html>